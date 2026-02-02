<!doctype html>
<html lang="en">
{include file="head.tpl" title=$title}
<body>
  <div class="container">
    {include file="header.tpl" title=$title subtitle=$subtitle}
    {include file="summary-cards.tpl"
      totalErrors=$totalErrors
      totalFilesWithErrors=$totalFilesWithErrors
      warningsCount=$warningsCount
      internalErrorsCount=$internalErrorsCount
    }
    {include file="summary-grid.tpl"
      errorTypeCounts=$errorTypeCounts
      filesByErrorCount=$filesByErrorCount
    }
    {include file="file-errors.tpl" totalErrors=$totalErrors errorsByFile=$errorsByFile}
    {include file="project-errors.tpl" notFileErrors=$notFileErrors}
    {include file="warnings.tpl" warnings=$warnings}
    {include file="internal-errors.tpl" internalErrors=$internalErrors}
  </div>
  {include file="scripts.tpl"
    errorTypeLabelsJson=$errorTypeLabelsJson
    errorTypeDataJson=$errorTypeDataJson
  }
</body>
</html>
