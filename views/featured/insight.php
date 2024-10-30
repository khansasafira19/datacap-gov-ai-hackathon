<?php
function formatInsight($insight)
{
    // Split content into lines by sentence ends
    $lines = explode("\n", $insight);
    $formattedText = '';

    foreach ($lines as $line) {
        $trimmedLine = trim($line);

        // Detect main headings based on keywords (e.g., "Tren Persentase Penduduk Miskin")
        if (preg_match('/^###\s*(.*)/', $trimmedLine, $matches)) {
            $formattedText .= "<h6>" . htmlspecialchars($matches[1]) . "</h6>";
        }
        // Detect list items starting with hyphen (-) or bullet point
        elseif (preg_match('/^- (.*)/', $trimmedLine, $matches)) {
            $formattedText .= "<ul><li>" . htmlspecialchars($matches[1]) . "</li></ul>";
        }
        // For any other sentence, treat it as a paragraph
        else {
            $formattedText .= "<p>" . htmlspecialchars($trimmedLine) . "</p>";
        }
    }

    // Remove cut-off sentence, if any, by removing trailing partial words
    $formattedText = preg_replace('/\s+[^.!?]*$/', '', $formattedText);

    return $formattedText;
}

// Apply formatting
$formattedInsight = formatInsight($insight);
?>

<!-- Display formatted content in HTML -->
<div class="insight-content">
    <h4>AI-Generated Insight:</h4>
    <?= $formattedInsight ?>
</div>
<style>
    
</style>