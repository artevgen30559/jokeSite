<?php

const RECORDS_PER_PAGE = 2;

function pagination($query, $pdo) {
    $page = $_SESSION['page'];
    if ($page == '') $page = 1;

    $recordsCount = getRecordsCount($query, $pdo);
    $countPage = ceil($recordsCount / RECORDS_PER_PAGE);
    $from = ($page - 1) * RECORDS_PER_PAGE;
    $setLimit = " LIMIT $from, ".RECORDS_PER_PAGE;

    $hrefs = createHrefs($countPage);

    return [
        'limit' => $setLimit,
        'hrefs' => $hrefs
    ];
}

function createHrefs($countPage) {
    $hrefs = [];
    for ($i = 1; $i <= $countPage; $i++) {
        $hrefs[] = "<a href=\"?page=$i\">$i</a>";
    }
    return $hrefs;
}

function getRecordsCount($string, $pdo) {
    $pattern = '#\b(.*)FROM#';
    $string = preg_replace($pattern, 'FROM', $string);

    $query = $pdo->query("SELECT COUNT(*) as recordsCount $string");
    return $query->fetch()['recordsCount'];
}

// Logic
// Page 1: Limit 0 2
// Page 2: Limit 2 2
// Page 3: Limit 4 2
// Page 4: Limit 6 2
// Page 5: Limit 8 2
