<?php

declare(strict_types=1);

namespace DDr1nk\PhpstanHtmlOutputFormatter;

use PHPStan\Analyser\Error;
use PHPStan\Analyser\InternalError;
use PHPStan\Command\AnalysisResult;
use PHPStan\Command\ErrorFormatter\ErrorFormatter;
use PHPStan\Command\Output;

final class HtmlErrorFormatter implements ErrorFormatter
{
    public function formatErrors(AnalysisResult $analysisResult, Output $output): int
    {
        $fileErrors = $analysisResult->getFileSpecificErrors();
        $notFileErrors = $analysisResult->getNotFileSpecificErrors();
        $internalErrors = $analysisResult->getInternalErrorObjects();
        $warnings = $analysisResult->getWarnings();

        $errorsByFile = [];
        $errorTypeCounts = [];
        foreach ($fileErrors as $error) {
            $file = $error->getFile();
            $errorsByFile[$file][] = $error;

            $identifier = $error->getIdentifier();
            $typeKey = $identifier !== null ? $identifier : 'general';
            $errorTypeCounts[$typeKey] = ($errorTypeCounts[$typeKey] ?? 0) + 1;
        }
        foreach ($notFileErrors as $error) {
            $identifier = $error->getIdentifier();
            $typeKey = $identifier !== null ? $identifier : 'general';
            $errorTypeCounts[$typeKey] = ($errorTypeCounts[$typeKey] ?? 0) + 1;
        }
        ksort($errorsByFile, SORT_STRING);
        arsort($errorTypeCounts);

        $filesByErrorCount = $errorsByFile;
        uasort($filesByErrorCount, static function (array $a, array $b): int {
            return count($b) <=> count($a);
        });

        $totalErrors = $analysisResult->getTotalErrorsCount();
        $totalFilesWithErrors = count($errorsByFile);

        $lines = [];
        $lines[] = '<!doctype html>';
        $lines[] = '<html lang="en">';
        $lines[] = '<head>';
        $lines[] = '  <meta charset="utf-8">';
        $lines[] = '  <meta name="viewport" content="width=device-width, initial-scale=1">';
        $lines[] = '  <title>PHPStan Report</title>';
        $lines[] = '  <style>';
        $lines[] = '    :root {';
        $lines[] = '      color-scheme: dark;';
        $lines[] = '      --bg: #0f1115;';
        $lines[] = '      --panel: #161a22;';
        $lines[] = '      --panel-2: #1f2430;';
        $lines[] = '      --text: #e6e6e6;';
        $lines[] = '      --muted: #98a2b3;';
        $lines[] = '      --accent: #7aa2f7;';
        $lines[] = '      --danger: #f7768e;';
        $lines[] = '      --warning: #e0af68;';
        $lines[] = '      --border: #2a2f3a;';
        $lines[] = '    }';
        $lines[] = '    * { box-sizing: border-box; }';
        $lines[] = '    body {';
        $lines[] = '      margin: 0;';
        $lines[] = '      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;';
        $lines[] = '      background: var(--bg);';
        $lines[] = '      color: var(--text);';
        $lines[] = '    }';
        $lines[] = '    .container { max-width: 1100px; margin: 0 auto; padding: 32px 20px 64px; }';
        $lines[] = '    h1 { font-size: 24px; margin: 0 0 12px; }';
        $lines[] = '    h2 { font-size: 18px; margin: 32px 0 12px; }';
        $lines[] = '    h3 { font-size: 16px; margin: 0 0 10px; }';
        $lines[] = '    .muted { color: var(--muted); }';
        $lines[] = '    .summary { display: grid; gap: 12px; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); margin-top: 16px; }';
        $lines[] = '    .summary-grid { display: grid; gap: 16px; grid-template-columns: 2fr 1fr; margin-top: 24px; }';
        $lines[] = '    .card { padding: 14px 16px; background: var(--panel); border: 1px solid var(--border); border-radius: 8px; }';
        $lines[] = '    .card strong { display: block; font-size: 20px; }';
        $lines[] = '    .list { margin: 0; padding: 0; list-style: none; }';
        $lines[] = '    .list li { padding: 8px 10px; border: 1px solid var(--border); border-radius: 6px; margin-bottom: 8px; background: rgba(0,0,0,0.12); }';
        $lines[] = '    .pill { display: inline-block; padding: 2px 8px; border-radius: 999px; background: rgba(255,255,255,0.06); color: var(--muted); font-size: 12px; margin-left: 8px; }';
        $lines[] = '    .scroll { max-height: 280px; overflow: auto; padding-right: 4px; }';
        $lines[] = '    .section { margin-top: 24px; }';
        $lines[] = '    .file { margin-top: 16px; padding: 14px 16px; background: var(--panel-2); border: 1px solid var(--border); border-radius: 8px; }';
        $lines[] = '    .file-header { display: flex; gap: 12px; align-items: baseline; justify-content: space-between; }';
        $lines[] = '    .badge { font-size: 12px; color: var(--muted); background: rgba(255,255,255,0.04); padding: 2px 8px; border-radius: 999px; }';
        $lines[] = '    ul { list-style: none; padding: 0; margin: 10px 0 0; }';
        $lines[] = '    li { padding: 10px 12px; border: 1px solid var(--border); border-radius: 6px; margin-bottom: 8px; background: rgba(0,0,0,0.15); }';
        $lines[] = '    .errors-list li { display: flex; flex-direction: column; gap: 6px; }';
        $lines[] = '    .error-meta { color: var(--muted); font-size: 12px; display: flex; gap: 8px; flex-wrap: wrap; }';
        $lines[] = '    .file-name { color: var(--accent); }';
        $lines[] = '    .error-message { font-size: 14px; }';
        $lines[] = '    .line { color: var(--muted); margin-right: 8px; }';
        $lines[] = '    .identifier { color: var(--accent); font-size: 12px; margin-left: 8px; }';
        $lines[] = '    .tip { margin-top: 6px; color: var(--muted); font-size: 13px; }';
        $lines[] = '    .empty { padding: 16px; border: 1px dashed var(--border); border-radius: 8px; color: var(--muted); }';
        $lines[] = '    .danger { color: var(--danger); }';
        $lines[] = '    .warning { color: var(--warning); }';
        $lines[] = '    .pager { display: flex; gap: 8px; align-items: center; margin-top: 12px; flex-wrap: wrap; }';
        $lines[] = '    .pager button { background: var(--panel); color: var(--text); border: 1px solid var(--border); padding: 6px 10px; border-radius: 6px; cursor: pointer; }';
        $lines[] = '    .pager button[disabled] { opacity: 0.5; cursor: default; }';
        $lines[] = '    .pager .page-info { color: var(--muted); }';
        $lines[] = '  </style>';
        $lines[] = '</head>';
        $lines[] = '<body>';
        $lines[] = '  <div class="container">';
        $lines[] = '    <h1>PHPStan Report</h1>';
        $lines[] = '    <div class="muted">Generated by phpstan-html-output-formatter</div>';
        $lines[] = '    <div class="summary">';
        $lines[] = '      <div class="card"><strong class="danger">' . $this->escape((string) $totalErrors) . '</strong>Errors</div>';
        $lines[] = '      <div class="card"><strong>' . $this->escape((string) $totalFilesWithErrors) . '</strong>Files with errors</div>';
        $lines[] = '      <div class="card"><strong class="warning">' . $this->escape((string) count($warnings)) . '</strong>Warnings</div>';
        $lines[] = '      <div class="card"><strong>' . $this->escape((string) count($internalErrors)) . '</strong>Internal errors</div>';
        $lines[] = '    </div>';

        $lines[] = '    <div class="summary-grid">';
        $lines[] = '      <div class="card">';
        $lines[] = '        <h3>Error types</h3>';
        if ($errorTypeCounts === []) {
            $lines[] = '        <div class="empty">No errors to summarize.</div>';
        } else {
            $lines[] = '        <ul class="list scroll">';
            foreach ($errorTypeCounts as $type => $count) {
                $label = $type === 'general' ? 'General' : $type;
                $lines[] = '          <li>' . $this->escape($label) . '<span class="pill">' . $this->escape((string) $count) . '</span></li>';
            }
            $lines[] = '        </ul>';
        }
        $lines[] = '      </div>';
        $lines[] = '      <div class="card">';
        $lines[] = '        <h3>Files needing attention</h3>';
        if ($filesByErrorCount === []) {
            $lines[] = '        <div class="empty">No files with errors.</div>';
        } else {
            $lines[] = '        <ul class="list scroll">';
            $shown = 0;
            foreach ($filesByErrorCount as $file => $errors) {
                $lines[] = '          <li>' . $this->escape($file) . '<span class="pill">' . $this->escape((string) count($errors)) . '</span></li>';
                $shown++;
                if ($shown >= 10) {
                    break;
                }
            }
            $lines[] = '        </ul>';
        }
        $lines[] = '      </div>';
        $lines[] = '    </div>';

        $lines[] = '    <div class="section">';
        $lines[] = '      <h2>File errors</h2>';
        if ($totalErrors === 0) {
            $lines[] = '      <div class="empty">No errors found.</div>';
        } else {
            $lines[] = '      <div class="pager" id="pager">';
            $lines[] = '        <button id="prevPage">Prev</button>';
            $lines[] = '        <span class="page-info" id="pageInfo"></span>';
            $lines[] = '        <button id="nextPage">Next</button>';
            $lines[] = '      </div>';
            $lines[] = '      <ul class="errors-list">';
            foreach ($fileErrors as $error) {
                $lines[] = $this->renderFileErrorItem($error);
            }
            $lines[] = '      </ul>';
        }
        $lines[] = '    </div>';

        $lines[] = '    <div class="section">';
        $lines[] = '      <h2>Project errors</h2>';
        if ($notFileErrors === []) {
            $lines[] = '      <div class="empty">No project-level errors.</div>';
        } else {
            $lines[] = '      <ul>';
            foreach ($notFileErrors as $error) {
                $lines[] = $this->renderErrorItem($error);
            }
            $lines[] = '      </ul>';
        }
        $lines[] = '    </div>';

        $lines[] = '    <div class="section">';
        $lines[] = '      <h2>Warnings</h2>';
        if ($warnings === []) {
            $lines[] = '      <div class="empty">No warnings.</div>';
        } else {
            $lines[] = '      <ul>';
            foreach ($warnings as $warning) {
                $lines[] = '        <li>' . $this->escape($warning) . '</li>';
            }
            $lines[] = '      </ul>';
        }
        $lines[] = '    </div>';

        $lines[] = '    <div class="section">';
        $lines[] = '      <h2>Internal errors</h2>';
        if ($internalErrors === []) {
            $lines[] = '      <div class="empty">No internal errors.</div>';
        } else {
            $lines[] = '      <ul>';
            foreach ($internalErrors as $internalError) {
                $lines[] = $this->renderInternalErrorItem($internalError);
            }
            $lines[] = '      </ul>';
        }
        $lines[] = '    </div>';

        $lines[] = '  </div>';
        $lines[] = '  <script>';
        $lines[] = '    (function () {';
        $lines[] = '      const items = Array.from(document.querySelectorAll(\'[data-page-item="true"]\'));';
        $lines[] = '      if (items.length === 0) return;';
        $lines[] = '      const pageSize = 50;';
        $lines[] = '      let current = 1;';
        $lines[] = '      const totalPages = Math.max(1, Math.ceil(items.length / pageSize));';
        $lines[] = '      const prev = document.getElementById(\'prevPage\');';
        $lines[] = '      const next = document.getElementById(\'nextPage\');';
        $lines[] = '      const info = document.getElementById(\'pageInfo\');';
        $lines[] = '      const render = () => {';
        $lines[] = '        const start = (current - 1) * pageSize;';
        $lines[] = '        const end = start + pageSize;';
        $lines[] = '        items.forEach((el, idx) => {';
        $lines[] = '          el.style.display = idx >= start && idx < end ? \'block\' : \'none\';';
        $lines[] = '        });';
        $lines[] = '        info.textContent = `Page ${current} of ${totalPages}`;';
        $lines[] = '        prev.disabled = current <= 1;';
        $lines[] = '        next.disabled = current >= totalPages;';
        $lines[] = '      };';
        $lines[] = '      prev.addEventListener(\'click\', () => { if (current > 1) { current--; render(); } });';
        $lines[] = '      next.addEventListener(\'click\', () => { if (current < totalPages) { current++; render(); } });';
        $lines[] = '      render();';
        $lines[] = '    })();';
        $lines[] = '  </script>';
        $lines[] = '</body>';
        $lines[] = '</html>';

        $output->writeRaw(implode("\n", $lines));

        return $analysisResult->hasErrors() || $analysisResult->hasInternalErrors() ? 1 : 0;
    }

    private function renderErrorItem(Error $error): string
    {
        $line = $error->getLine();
        $identifier = $error->getIdentifier();
        $tip = $error->getTip();

        $lineLabel = $line !== null ? '<span class="line">Line ' . $this->escape((string) $line) . '</span>' : '';
        $identifierLabel = $identifier !== null ? '<span class="identifier">' . $this->escape($identifier) . '</span>' : '';

        $content = '        <li>'
            . $lineLabel
            . $this->escape($error->getMessage())
            . $identifierLabel;

        if ($tip !== null && $tip !== '') {
            $content .= '<div class="tip">' . $this->escape($tip) . '</div>';
        }

        $content .= '</li>';

        return $content;
    }

    private function renderFileErrorItem(Error $error): string
    {
        $line = $error->getLine();
        $identifier = $error->getIdentifier();
        $tip = $error->getTip();
        $file = $error->getFile();

        $fileLabel = $file !== null ? '<span class="file-name">' . $this->escape($file) . '</span>' : '';
        $lineLabel = $line !== null ? '<span class="line">Line ' . $this->escape((string) $line) . '</span>' : '';
        $identifierLabel = $identifier !== null ? '<span class="identifier">' . $this->escape($identifier) . '</span>' : '';

        $content = '        <li data-page-item="true">';
        $content .= '<div class="error-meta">' . $fileLabel . $lineLabel . $identifierLabel . '</div>';
        $content .= '<div class="error-message">' . $this->escape($error->getMessage()) . '</div>';

        if ($tip !== null && $tip !== '') {
            $content .= '<div class="tip">' . $this->escape($tip) . '</div>';
        }

        $content .= '</li>';

        return $content;
    }

    private function renderInternalErrorItem(InternalError $internalError): string
    {
        $message = $internalError->getMessage();
        $context = $internalError->getContextDescription();

        $content = '        <li>'
            . $this->escape($message);

        if ($context !== null && $context !== '') {
            $content .= '<div class="tip">' . $this->escape($context) . '</div>';
        }

        $content .= '</li>';

        return $content;
    }

    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
