<?php

namespace ClimbUI\Service;

require_once __DIR__ . '/../../support/lib/vendor/autoload.php';

use Approach\Service\format;
use Approach\Service\Service;
use Approach\Service\target;

/*
 * Github
 * Gets information from a GitHub repo and returns a list of issues
 */
class Github extends Service
{
    /**
     * @return array<string,null|string|array|bool>
     */
    public static function getApiKey()
    {
        $filename = __DIR__ . '/../../config.json';
        if (!file_exists($filename)) {
            $file = fopen($filename, "w");
            if ($file) 
                fclose($file);
        }

        $content = file_get_contents($filename);
        $config = json_decode($content, true);
        $key = $config['GITHUB_API_KEY'];
        return $key;
    }

    /**
     * @var mixed|null
     */
    public string $url;

    public function __construct(
        $owner = null,
        $repo = null,
        $labels = null,
        $url = null,
    ) {
        $this->url = $url ?? 'https://api.github.com/repos/' . $owner . '/' . $repo . '/issues?labels=' . implode(',', $labels);
        $context = [
            'http' => [
                'method' => 'GET',
                'header' => [
                    'User-Agent:curl/8.5.0',
                    'Authorization: Bearer ' . self::getApiKey(),
                    'X-GitHub-Api-Version: 2022-11-28',
                ],
            ]
        ];

        parent::__construct(
            auto_dispatch: false,
            format_in: format::json,
            format_out: format::raw,
            target_in: target::stream,
            target_out: target::variable,
            input: [$this->url],
            metadata: [['context' => $context]]
        );
    }

    /*
     * @param string $body
     * @return mixed
     */
    public function parseIssue($body): array
    {
        $dom = new \DOMDocument();
        // FIXME: This suppresses all the errors, but should handled
        libxml_use_internal_errors(true);
        $dom->loadHTML($body);
        libxml_clear_errors();
        $details = $dom->getElementsByTagName('details')->item(6);
        // check if details in empty
        if (!$details) {
            $details = $dom->getElementsByTagName('details')->item(0); 
        }
        $detailsContent = $details->nodeValue;

        $main = $dom->getElementsByTagName('main')->item(0);
        $mainContent = '';
        foreach ($main->childNodes as $m) {
            $mainContent .= $main->ownerDocument->saveHTML($m);
        }

        return [
            'body' => $mainContent,
            'details' => $detailsContent, true
        ];
    }

    /**
     * @param mixed $labels
     */
    public function returnLabelName($labels): array
    {
        $labelNames = [];
        foreach ($labels as $label) {
            $labelNames[] = $label['name'];
        }

        return $labelNames;
    }

    /**
     * @param mixed $issue
     * @return array<string,mixed>
     */
    public function processIssue(mixed $issue): array
    {
        $res = [];
        $res['number'] = $issue['number'];
        $res['title'] = $issue['title'];
        $res['url'] = $issue['repository_url'];
        $res['labels'] = $this->returnLabelName($issue['labels']);
        $res['user_login'] = $issue['user']['login'];
        $res['user_avatar'] = $issue['user']['avatar_url'];
        $res['is_admin'] = $issue['author_association'] === 'OWNER' || $issue['author_association'] === 'MEMBER';
        $res['assignees'] = $issue['assignees'];
        $parsed = $this->parseIssue($issue['body']);
        $res['body'] = $parsed['body'];
        $res['details'] = $parsed['details'];

        return $res;
    }

    public function Process(?array $payload = null): void
    {
        $payload = $this->payload ?? $payload;
        $res = [];
        foreach ($payload as &$p) {
            foreach ($p as $issue) {
                $res[] = $this->processIssue($issue);
            }
            $p = $res;
        }
        $this->payload = $payload;
    }

    public function getIssues(): array
    {
        $results = $this->dispatch();
        return $results;
    }
}
