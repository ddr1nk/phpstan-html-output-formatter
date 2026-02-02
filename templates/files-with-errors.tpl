<div class="card">
  <h3>Files with errors</h3>
  {if $filesByErrorCount|@count == 0}
    <div class="empty">No files with errors.</div>
  {else}
    <ul class="list scroll">
      {foreach $filesByErrorCount as $entry name=files}
        {if $smarty.foreach.files.index < 10}
          <li>{$entry.file}<span class="pill">{$entry.count}</span></li>
        {/if}
      {/foreach}
    </ul>
  {/if}
</div>
