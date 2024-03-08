<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Word Frequency Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #333;
            margin-top: 20px;
        }
        th {
            background-color: #333;
            color: #fff;
            font-weight: bold;
            padding: 10px;
            border: 1px solid #555;
            text-align: left;
        }
        td {
            padding: 8px;
            border: 1px solid #ccc;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Word Frequency Results</h1>

    <?php
    function calculateWordFrequency($words) {
        $stopWords = ["the", "and", "in"];
        
        $wordFrequency = array_count_values($words);
        
        foreach ($stopWords as $stopWord) {
            unset($wordFrequency[$stopWord]);
        }
        
        return $wordFrequency;
    }

    function sortWordFrequency($wordFrequency, $sortOrder) {
        if ($sortOrder === "asc") {
            asort($wordFrequency);
        } else {
            arsort($wordFrequency);
        }
        return $wordFrequency;
    }

    function limitWordFrequency($wordFrequency, $limit) {
        return array_slice($wordFrequency, 0, $limit);
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $inputText = $_POST['text'];
        $selectedSortOrder = $_POST['sort']; 
        $selectedLimit = $_POST['limit']; 

        $words = str_word_count(strtolower($inputText), 1);

        $wordFrequency = calculateWordFrequency($words);

        $sortedWordFrequency = sortWordFrequency($wordFrequency, $selectedSortOrder);

        $limitedWordFrequency = limitWordFrequency($sortedWordFrequency, $selectedLimit);
        
        echo '<table>';
        echo '<tr><th>Word</th><th>Frequency</th></tr>';
            foreach ($limitedWordFrequency as $word => $frequency) {
            echo "<tr><td>$word</td><td>$frequency</td></tr>";
        }
        
        echo '</table>';
    } else {

        echo '<p>No data submitted.</p>';
    }
    ?>

</body>
</html>
