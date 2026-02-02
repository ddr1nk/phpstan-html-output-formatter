<div class="section">
  <h2>Project errors</h2>
  {if $notFileErrors|@count == 0}
    <div class="empty">No project-level errors.</div>
  {else}
    <ul>
      {foreach $notFileErrors as $error}
        <li>
          {if $error.line != null}<span class="line">Line {$error.line}</span>{/if}
          {$error.message}
          {if $error.identifier != null}<span class="identifier">{$error.identifier}</span>{/if}
          {if $error.tip != null && $error.tip != ''}<div class="tip">{$error.tip}</div>{/if}
        </li>
      {/foreach}
    </ul>
  {/if}
</div>
