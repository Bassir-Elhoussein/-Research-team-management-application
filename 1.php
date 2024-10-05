<!DOCTYPE html>
<html>
<head>
    <style>table.redTable {
        border: 2px solid #A40808;
        background-color: #EEE7DB;
        width: 100%;
        text-align: center;
        border-collapse: collapse;
      }
      table.redTable td, table.redTable th {
        border: 1px solid #AAAAAA;
        padding: 3px 2px;
      }
      table.redTable tbody td {
        font-size: 21px;
      }
      table.redTable tr:nth-child(even) {
        background: #F5C8BF;
      }
      table.redTable thead {
        background: #A40808;
        border-bottom: 0px solid #444444;
      }
      table.redTable thead th {
        font-size: 19px;
        font-weight: bold;
        color: #FFFFFF;
        text-align: center;
        border-left: 0px solid #A40808;
      }
      table.redTable thead th:first-child {
        border-left: none;
      }
      
      table.redTable tfoot {
        font-size: 20px;
        font-weight: bold;
        background: #A40808;
      }
      table.redTable tfoot td {
        font-size: 20px;
      }</style>
    
    </style>>
</head>
<body>
    <table class="redTable">
<thead>
<tr>
<th>ID</th>
<th>FULL NAME</th>
<th>PHONE</th>
<th>CITY</th>
<th>MAIL ADRESS</th>
<th>WEBSITE</th>
</tr>
</thead>

<tbody>
<?php

global $wpdb;
$result = $wpdb->get_results( "SELECT ID, FULL_NAME, PHONE, CITY,MAILL_ADRESS FROM members");

foreach ($result as $row) {
	echo "<tr>";
  echo "<td>" . $row->ID . "</td>";
  echo "<td>" . $row->FULL_NAME . "</td>";
  echo "<td>" . $row->PHONE . "</td>";
  echo "<td>" . $row->CITY . "</td>";
  echo "<td>" . $row->MAIL_ADRESS . "</td>";
  echo "<td><a href=". $row->MAIL_ADRESS ."></a>/td>";
  echo "</tr>";
}


?>
</table>

</body>
</html>