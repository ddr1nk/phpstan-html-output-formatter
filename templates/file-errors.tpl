<div class="section">
  <h2>File errors</h2>
  {if $totalErrors == 0}
    <div class="empty">No errors found.</div>
  {else}
    <div class="controls">
      <input id="filterText" type="text" placeholder="Filter by file, message, identifier...">
      <label class="muted">Page size
        <select id="pageSize">
          <option value="10">10</option>
          <option value="20">20</option>
          <option value="50" selected>50</option>
          <option value="100">100</option>
        </select>
      </label>
    </div>
    <div class="pager" id="pager">
      <button id="prevPage">Prev</button>
      <span class="page-info" id="pageInfo"></span>
      <button id="nextPage">Next</button>
    </div>
    {foreach $errorsByFile as $entry}
      <details class="file" data-file-block="true" data-file="{$entry.fileKey}">
        <summary class="file-header">
          <span class="badge" data-file-count="true">{$entry.count} issues</span>
          <h3>{$entry.file}</h3>
        </summary>
        <ul class="errors-list">
          {foreach $entry.errors as $error}
            <li data-search="{$error.search}">
              {if $error.line != null}<span class="line">Line {$error.line}</span>{/if}
              {$error.message}
              {if $error.identifier != null}<span class="identifier">{$error.identifier}</span>{/if}
              {if $error.tip != null && $error.tip != ''}<div class="tip">{$error.tip}</div>{/if}
            </li>
          {/foreach}
        </ul>
      </details>
    {/foreach}
  {/if}
</div>
