<?php

// SERVER-SIDE PROCESSING OF BOOTGRID

/* CLIENT SIDE DATA */
$params = $_POST; // OR $_GET

/* INIT VARIABLES */
$rows = [];
$total = 0;
$search = "";
$order = "";
$limit = "";

/* SORT, ALWAYS USING (COLUMN, INIT SORT ETC.) */
$sort['col'] = "ID";
$sort['way'] = "DESC";
if (isset($params['sort'])) {
    foreach ($params['sort'] as $index => $item) {
        $sort['col'] = $index;
        $sort['way'] = $item;
    }

    $order = " ORDER BY {$sort['col']} {$sort['way']} ";
}

/* type : 1 > mysql - 2 > mssql
function limit($current, $rowCount, $type) {
    switch(type){
        case 1:
            //.....
            break;
        case 2:
            if ($rowCount > -1) {
                $offset = 0;
                $row = 0;
                if ($current == 1) {
                    $row = $rowCount;
                } else {
                    $row = $rowCount;
                    $offset = ($rowCount * ($current-1));
                }
                $limit = " OFFSET {$offset} ROWS FETCH NEXT {$row} ROWS ONLY ";
            }
            break;
    }
    return $limit;
}

/* LIMIT, ALWAYS USING (PAGINATION ETC.) */
$limit = limit($params['current'], $params['rowCount'], 1)

/* IF SEARCH USING */
if (isset($params['searchPhrase']) && $params['searchPhrase'] != "") {
    $search = " AND (col_1 LIKE '%{$params['searchPhrase']}%' OR col_2 LIKE '%{$params['searchPhrase']}%') ";
}

/* MAIN QUERY */
$sql_group_users = "SELECT * FROM table WHERE 1 = 1 {$search} {$order} {$limit}";

/* FETCH QUERY AS ARRAY DATA */
$rows = $db->query($sql_group_users)->fetchAll();

/* CALCULATING TOTAL ROWS*/
if ($search != "") {
    $total = count($db->query("SELECT * FROM table WHERE 1 = 1 {$search}")->fetchAll());
} else {
    $total = count($db->query("SELECT * FROM dbo.RB_BUTCE_GRUP_USER WHERE 1 = 1")->fetchAll());
}

/* PREPAIRING RESULTS */
$_POST['rows'] = $rows;
$_POST['total'] = $total;

/* OUTPUT  */
echo json_encode($_POST);
exit();
