<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{$title}</title>
  <style>
    :root {
      color-scheme: dark;
      --bg: #0f1115;
      --panel: #161a22;
      --panel-2: #1f2430;
      --text: #e6e6e6;
      --muted: #98a2b3;
      --accent: #7aa2f7;
      --danger: #f7768e;
      --warning: #e0af68;
      --border: #2a2f3a;
    }
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      background: var(--bg);
      color: var(--text);
    }
    .container { max-width: 100%; margin: 0 auto; padding: 32px 24px 64px; }
    h1 { font-size: 24px; margin: 0 0 12px; }
    h2 { font-size: 18px; margin: 32px 0 12px; }
    h3 { font-size: 16px; margin: 0 0 10px; }
    .muted { color: var(--muted); }
    .summary { display: grid; gap: 12px; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); margin-top: 16px; }
    .summary-grid { display: grid; gap: 16px; grid-template-columns: 2fr 3fr; margin-top: 24px; }
    .card { padding: 14px 16px; background: var(--panel); border: 1px solid var(--border); border-radius: 8px; }
    .card strong { display: block; font-size: 20px; }
    .chart-wrap { display: grid; gap: 16px; grid-template-columns: minmax(220px, 1fr) 2fr; align-items: start; }
    .chart { background: rgba(0,0,0,0.2); border: 1px solid var(--border); border-radius: 8px; padding: 12px; }
    .list { margin: 0; padding: 0; list-style: none; }
    .list li { padding: 8px 10px; border: 1px solid var(--border); border-radius: 6px; margin-bottom: 8px; background: rgba(0,0,0,0.12); }
    .pill { display: inline-block; padding: 2px 8px; border-radius: 999px; background: rgba(255,255,255,0.06); color: var(--muted); font-size: 12px; margin-left: 8px; }
    .scroll { max-height: 280px; overflow: auto; padding-right: 4px; }
    .section { margin-top: 24px; }
    .file { margin-top: 16px; padding: 14px 16px; background: var(--panel-2); border: 1px solid var(--border); border-radius: 8px; }
    .file-header { display: flex; gap: 12px; align-items: center; justify-content: flex-start; }
    .copy-btn { border: 1px solid var(--border); background: var(--panel); color: var(--muted); border-radius: 6px; padding: 2px 6px; cursor: pointer; font-size: 12px; }
    .copy-btn:hover { color: var(--text); }
    .copy-btn:active { transform: translateY(1px); }
    .file summary { cursor: pointer; list-style: none; }
    .file summary::-webkit-details-marker { display: none; }
    .file summary::after { content: "▸"; color: var(--muted); font-size: 14px; margin-left: auto; transition: transform 0.15s ease; }
    .file[open] summary::after { transform: rotate(90deg); }
    .badge { flex: 0 0 auto; }
    .badge { font-size: 12px; color: var(--muted); background: rgba(255,255,255,0.04); padding: 2px 8px; border-radius: 999px; }
    ul { list-style: none; padding: 0; margin: 10px 0 0; }
    li { padding: 10px 12px; border: 1px solid var(--border); border-radius: 6px; margin-bottom: 8px; background: rgba(0,0,0,0.15); }
    .errors-list li { display: flex; flex-direction: column; gap: 6px; }
    .error-meta { color: var(--muted); font-size: 12px; display: flex; gap: 8px; flex-wrap: wrap; }
    .file-name { color: var(--accent); }
    .error-message { font-size: 14px; }
    .line { color: var(--muted); margin-right: 8px; }
    .identifier { color: var(--accent); font-size: 12px; margin-left: 8px; }
    .tip { margin-top: 6px; color: var(--muted); font-size: 13px; }
    .empty { padding: 16px; border: 1px dashed var(--border); border-radius: 8px; color: var(--muted); }
    .danger { color: var(--danger); }
    .warning { color: var(--warning); }
    .pager { display: flex; gap: 8px; align-items: center; margin-top: 12px; flex-wrap: wrap; }
    .pager button { background: var(--panel); color: var(--text); border: 1px solid var(--border); padding: 6px 10px; border-radius: 6px; cursor: pointer; }
    .pager button[disabled] { opacity: 0.5; cursor: default; }
    .pager .page-info { color: var(--muted); }
    .controls { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; margin-top: 12px; }
    .controls input, .controls select { background: var(--panel); color: var(--text); border: 1px solid var(--border); padding: 6px 10px; border-radius: 6px; }
  </style>
</head>
