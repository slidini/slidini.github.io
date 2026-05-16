<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>lewandowski-olivier</title>
    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
    <div id="header">
        <h1>Type Converter</h1>
    </div>

    <div class="container">
            <div id="left">

                <form method="post"  action="/index.php">
                    <label for="input-types">Select type of the input file:</label><br>
                    <select id="input-types" name="input-types">
                        <option value="none" <?= ($iType ?? '') === 'none' ? 'selected' : '' ?>>-</option>
                        <option value="TSV" <?= ($iType ?? '') === 'TSV' ? 'selected' : '' ?>>TSV</option>
                        <option value="CSV" <?= ($iType ?? '') === 'CSV' ? 'selected' : '' ?>>CSV</option>
                        <option value="SSV" <?= ($iType ?? '') === 'SSV' ? 'selected' : '' ?>>SSV</option>
                        <option value="JSON" <?= ($iType ?? '') === 'JSON' ? 'selected' : '' ?>>JSON</option>
                        <option value="YAML" <?= ($iType ?? '') === 'YAML' ? 'selected' : '' ?>>YAML</option>
                    </select><br>
                    <label for="output-types">Select type of the output file:</label><br>
                    <select id="output-types" name="output-types">
                        <option value="none"  <?= ($oType ?? '') === 'none' ? 'selected' : '' ?>>-</option>
                        <option value="TSV" <?= ($oType ?? '') === 'TSV' ? 'selected' : '' ?>>TSV</option>
                        <option value="CSV" <?= ($oType ?? '') === 'CSV' ? 'selected' : '' ?>>CSV</option>
                        <option value="SSV" <?= ($oType ?? '') === 'SSV' ? 'selected' : '' ?>>SSV</option>
                        <option value="JSON" <?= ($oType ?? '') === 'JSON' ? 'selected' : '' ?>>JSON</option>
                        <option value="YAML" <?= ($oType ?? '') === 'YAML' ? 'selected' : '' ?>>YAML</option>
                    </select><br>

                    <label for="inputText">Enter your file content to convert:</label><br>
                    <textarea name="inputText" id="inputText" class="txtAreas" cols="30" rows="10"><?=$input ?? ''?></textarea><br>
                    <button type="submit" name="submit" class="buttons">Convert</button>
                </form>
            </div>

            <div id="right">
                    <label for="outputData">Converted file:</label><br>
                    <textarea name="outputData" id="outputData" class="txtAreas" readonly><?=$output ?? ''?></textarea>
            </div>
    </div>
</body>
</html>