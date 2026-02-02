<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
{literal}
  (function () {
    const ctx = document.getElementById("errorTypeChart");
    if (!ctx) return;
    const labels = {/literal}{$errorTypeLabelsJson nofilter}{literal};
    const data = {/literal}{$errorTypeDataJson nofilter}{literal};
    if (labels.length === 0) return;
    if (typeof Chart === 'undefined') return;
    new Chart(ctx, {
      type: "doughnut",
      data: {
        labels,
        datasets: [{
          data,
          borderWidth: 1,
          borderColor: "#1f2430",
          backgroundColor: [
            "#7aa2f7", "#f7768e", "#e0af68", "#9ece6a", "#bb9af7", "#2ac3de",
            "#73daca", "#ff9e64", "#c0caf5", "#7dcfff", "#f7d794", "#b8dbd9"
          ]
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: "bottom", labels: { color: "#c0caf5", boxWidth: 10 } },
          tooltip: { enabled: true }
        }
      }
    });
  })();
  (function () {
    const blocks = Array.from(document.querySelectorAll('.file-block'));
    if (blocks.length === 0) return;
    const filterInput = document.getElementById('filterText');
    const sizeSelect = document.getElementById('pageSize');
    let current = 1;
    let totalPages = 1;
    const prev = document.getElementById('prevPage');
    const next = document.getElementById('nextPage');
    const info = document.getElementById('pageInfo');
    if (!filterInput || !sizeSelect || !prev || !next || !info) return;
    const normalize = (value) => value.toLowerCase().trim();
    const applyFilter = () => {
      const query = normalize(filterInput.value);
      const visible = [];
      blocks.forEach((block) => {
        const fileKey = block.getAttribute('data-file') || '';
        const fileMatches = query === '' || fileKey.includes(query);
        const errorItems = Array.from(block.querySelectorAll('[data-search]'));
        let visibleCount = 0;
        errorItems.forEach((item) => {
          const hay = item.getAttribute('data-search') || '';
          const matches = fileMatches || query === '' || hay.includes(query);
          item.style.display = matches ? 'block' : 'none';
          if (matches) {
            visibleCount++;
          }
        });
        const showBlock = fileMatches || visibleCount > 0;
        block.style.display = showBlock ? 'block' : 'none';
        const badge = block.querySelector('[data-file-count]');
        if (badge) {
          badge.textContent = String(visibleCount) + ' issues';
        }
        if (showBlock) {
          visible.push(block);
        }
      });
      return visible;
    };
    const render = () => {
      const pageSize = parseInt(sizeSelect.value, 10) || 50;
      const visible = applyFilter();
      totalPages = Math.max(1, Math.ceil(visible.length / pageSize));
      if (current > totalPages) current = totalPages;
      const start = (current - 1) * pageSize;
      const end = start + pageSize;
      visible.forEach((el, idx) => {
        el.style.display = idx >= start && idx < end ? 'block' : 'none';
      });
      info.textContent = 'Page ' + current + ' of ' + totalPages + ' (' + visible.length + ' files)';
      prev.disabled = current <= 1;
      next.disabled = current >= totalPages;
    };
    prev.addEventListener('click', () => { if (current > 1) { current--; render(); } });
    next.addEventListener('click', () => { if (current < totalPages) { current++; render(); } });
    filterInput.addEventListener('input', () => { current = 1; render(); });
    sizeSelect.addEventListener('change', () => { current = 1; render(); });
    render();
  })();
{/literal}
</script>
