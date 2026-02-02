<div class="section">
  <h2>Warnings</h2>
  {if $warnings|@count == 0}
    <div class="empty">No warnings.</div>
  {else}
    <ul>
      {foreach $warnings as $warning}
        <li>{$warning}</li>
      {/foreach}
    </ul>
  {/if}
</div>
