<div class="section">
  <h2>Internal errors</h2>
  {if $internalErrors|@count == 0}
    <div class="empty">No internal errors.</div>
  {else}
    <ul>
      {foreach $internalErrors as $error}
        <li>
          {$error.message}
          {if $error.context != null && $error.context != ''}<div class="tip">{$error.context}</div>{/if}
        </li>
      {/foreach}
    </ul>
  {/if}
</div>
