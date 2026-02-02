<div class="card">
  <h3>Error types</h3>
  {if $errorTypeCounts|@count == 0}
    <div class="empty">No errors to summarize.</div>
  {else}
    <div class="chart-wrap">
      <div class="chart">
        <canvas id="errorTypeChart" height="220"></canvas>
      </div>
      <ul class="list scroll">
        {foreach $errorTypeCounts as $type => $count}
          {if $type == 'general'}
            {assign var=label value='General'}
          {else}
            {assign var=label value=$type}
          {/if}
          <li>{$label}<span class="pill">{$count}</span></li>
        {/foreach}
      </ul>
    </div>
  {/if}
</div>
