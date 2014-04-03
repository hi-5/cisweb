<?php

/*
This file will generate a excel formatted xml file for the CIS standard report. It expects a teamId number as well as the year for which to generate the report.
If you have come here looking to change the output format... good luck. This was done in a hurry by simply conversting an existing xls file to xml and spitting it out.
*/

include "cislib.php";
include "connect.php";

include "./php/cislib.php";
loggedAdmin();

$filename = "default";
$year = "";
$teamId = "";
$teamName = "";
$workbook = "";
$styles = "";
$docHeader = "";
$columnHeaders = "";
$athleteRows = "";
$docFooter = "";

if (isset($_REQUEST["id"])) $teamId = $_REQUEST["id"];
    else {
        echo "Error: no teamId given";
        die(); 
    } 

if (isset($_REQUEST["year"])) $year = $_REQUEST["year"];
    else { 
        echo "Error: no year given";
        die();
    }

//Get the team name
global $sql;

$query = "SELECT DISTINCT t_name FROM teams WHERE t_id = $teamId";
$result = mysqli_query($sql, $query);
$temp = mysqli_fetch_assoc($result);
$teamName = $temp['t_name'];

//Get athlete info
$athleteQuery = "SELECT athletes.a_studentId, athletehistory.ah_jerseyNumber, athletes.a_firstName, athletes.a_lastName, athletehistory.ah_position, athletes.a_height, athletes.a_weight, athletes.a_dob, athletes.a_program, athletes.a_cProvince, athletes.a_hometown
FROM athletehistory
INNER JOIN athletes
ON athletehistory.ah_studentId=athletes.a_studentId
AND athletehistory.ah_year = $year
AND athletehistory.ah_teamId = $teamId
AND athletehistory.ah_institute = 'University of Lethbridge'
ORDER BY athletehistory.ah_jerseyNumber";

$athleteResult = mysqli_query($sql, $athleteQuery);

//This part prints out the rows with the actual athlete information.
while($row = mysqli_fetch_assoc($athleteResult)) {
    $athleteRows .= "<Row ss:AutoFitHeight=\"0\" ss:Height=\"15.9375\" ss:StyleID=\"s80\">
    <Cell ss:StyleID=\"s83\"><Data ss:Type=\"Number\">" . $row['ah_jerseyNumber'] . "</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">" . $row['a_firstName'] . "</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">" . $row['a_lastName'] . "</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">" . $row['ah_position'] . "</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\">" . $row['a_height'] . "</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\">" . $row['a_weight'] . "lbs</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s83\"><Data ss:Type=\"Number\">" . getEligibility($row['a_studentId'], $sql) . "</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s86\"><Data ss:Type=\"DateTime\">" . $row['a_dob'] . "</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\">" . $row['a_program'] . "</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s83\"><Data ss:Type=\"Number\">0</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\">" . $row['a_hometown'] . "</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">" . $row['a_cProvince'] . "</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">" . getLastTeamPlayed($row['a_studentId'], $sql) . "</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s87\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s87\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
   </Row>";
}


$workbook = "<?xml version=\"1.0\"?>
<?mso-application progid=\"Excel.Sheet\"?>
<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:o=\"urn:schemas-microsoft-com:office:office\"
 xmlns:x=\"urn:schemas-microsoft-com:office:excel\"
 xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:html=\"http://www.w3.org/TR/REC-html40\">
 <DocumentProperties xmlns=\"urn:schemas-microsoft-com:office:office\">
  <Author>University of Lethbridge CIS Database</Author>
  <Created>" . date("Y-m-d") .  "</Created>
  <Company>CIS</Company>
  <Version>1</Version>
 </DocumentProperties>
 <OfficeDocumentSettings xmlns=\"urn:schemas-microsoft-com:office:office\">
  <AllowPNG/>
 </OfficeDocumentSettings>
 <ExcelWorkbook xmlns=\"urn:schemas-microsoft-com:office:excel\">
  <WindowHeight>6510</WindowHeight>
  <WindowWidth>25230</WindowWidth>
  <WindowTopX>-15</WindowTopX>
  <WindowTopY>6465</WindowTopY>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
 </ExcelWorkbook>";

 $styles = "<Styles>
  <Style ss:ID=\"Default\" ss:Name=\"Normal\">
   <Alignment ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s62\" ss:Name=\"Normal 3\">
   <Alignment ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Color=\"#000000\"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m97759456\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"8.5\" ss:Italic=\"1\"/>
  </Style>
  <Style ss:ID=\"s63\">
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\"/>
  </Style>
  <Style ss:ID=\"s64\">
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\"/>
   <NumberFormat ss:Format=\"mm/dd/yy;@\"/>
  </Style>
  <Style ss:ID=\"s66\">
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Bold=\"1\"
    ss:Underline=\"Single\"/>
  </Style>
  <Style ss:ID=\"s67\">
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\" ss:Bold=\"1\"
    ss:Underline=\"Single\"/>
  </Style>
  <Style ss:ID=\"s70\">
   <Alignment ss:Horizontal=\"Right\" ss:Vertical=\"Bottom\"/>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Italic=\"1\"/>
  </Style>
  <Style ss:ID=\"s71\">
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\"/>
  </Style>
  <Style ss:ID=\"s72\">
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\"/>
  </Style>
  <Style ss:ID=\"s73\">
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\"/>
   <NumberFormat ss:Format=\"mm/dd/yy;@\"/>
  </Style>
  <Style ss:ID=\"s74\">
   <Alignment ss:Vertical=\"Bottom\" ss:WrapText=\"1\"/>
   <Borders/>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"9\"/>
  </Style>
  <Style ss:ID=\"s76\">
   <Alignment ss:Vertical=\"Bottom\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"9\"/>
   <Interior ss:Color=\"#D9D9D9\" ss:Pattern=\"Solid\"/>
  </Style>
  <Style ss:ID=\"s77\">
   <Alignment ss:Vertical=\"Bottom\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"9\"/>
   <Interior ss:Color=\"#D9D9D9\" ss:Pattern=\"Solid\"/>
   <NumberFormat ss:Format=\"mm/dd/yy;@\"/>
  </Style>
  <Style ss:ID=\"s78\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"9\" ss:Bold=\"1\"/>
   <Interior ss:Color=\"#D9D9D9\" ss:Pattern=\"Solid\"/>
  </Style>
  <Style ss:ID=\"s79\">
   <Alignment ss:Vertical=\"Bottom\" ss:WrapText=\"1\"/>
   <Borders/>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"9\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
  </Style>
  <Style ss:ID=\"s80\">
   <Alignment ss:Vertical=\"Bottom\" ss:WrapText=\"1\"/>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"9\"/>
  </Style>
  <Style ss:ID=\"s83\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s84\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Bottom\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s85\" ss:Parent=\"s62\">
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s86\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior/>
   <NumberFormat ss:Format=\"mm/dd/yy;@\"/>
  </Style>
  <Style ss:ID=\"s87\">
   <Alignment ss:Vertical=\"Bottom\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"9\"/>
  </Style>
  <Style ss:ID=\"s88\">
   <Alignment ss:Vertical=\"Bottom\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"9\"/>
  </Style>
  <Style ss:ID=\"s89\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Bottom\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s90\">
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"9\"/>
  </Style>
  <Style ss:ID=\"s92\">
   <Alignment ss:Vertical=\"Bottom\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"8\"/>
  </Style>
  <Style ss:ID=\"s93\" ss:Parent=\"s62\">
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Interior/>
  </Style>
  <Style ss:ID=\"s94\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s95\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Bottom\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s96\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior/>
   <NumberFormat ss:Format=\"mm/dd/yy;@\"/>
  </Style>
  <Style ss:ID=\"s97\">
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
  </Style>
  <Style ss:ID=\"s99\">
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\"/>
  </Style>
  <Style ss:ID=\"s100\">
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\"/>
   <NumberFormat ss:Format=\"mm/dd/yy;@\"/>
  </Style>
  <Style ss:ID=\"s101\">
   <Alignment ss:Horizontal=\"Right\" ss:Vertical=\"Bottom\"/>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\"/>
  </Style>
  <Style ss:ID=\"s102\">
   <Borders/>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\"/>
  </Style>
  <Style ss:ID=\"s103\">
   <Borders/>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\"/>
   <NumberFormat ss:Format=\"mm/dd/yy;@\"/>
  </Style>
 </Styles>";

 $docHeader = "<Worksheet ss:Name=\"English\">
  <Names>
   <NamedRange ss:Name=\"Print_Area\" ss:RefersTo=\"=English!R1C1:R43C15\"/>
  </Names>
  <Table ss:ExpandedColumnCount=\"16\" ss:ExpandedRowCount=\"44\" x:FullColumns=\"1\"
   x:FullRows=\"1\" ss:StyleID=\"s63\">
   <Column ss:StyleID=\"s63\" ss:Width=\"30\"/>
   <Column ss:StyleID=\"s63\" ss:AutoFitWidth=\"0\" ss:Width=\"44.25\"/>
   <Column ss:StyleID=\"s63\" ss:AutoFitWidth=\"0\" ss:Width=\"88.5\"/>
   <Column ss:Index=\"5\" ss:StyleID=\"s63\" ss:AutoFitWidth=\"0\" ss:Width=\"40.5\"
    ss:Span=\"2\"/>
   <Column ss:Index=\"8\" ss:StyleID=\"s64\" ss:AutoFitWidth=\"0\" ss:Width=\"52.5\"/>
   <Column ss:StyleID=\"s63\" ss:AutoFitWidth=\"0\" ss:Width=\"123.75\"/>
   <Column ss:StyleID=\"s63\" ss:Width=\"31.5\"/>
   <Column ss:StyleID=\"s63\" ss:AutoFitWidth=\"0\" ss:Width=\"96\"/>
   <Column ss:StyleID=\"s63\" ss:AutoFitWidth=\"0\" ss:Width=\"41.25\"/>
   <Column ss:StyleID=\"s63\" ss:AutoFitWidth=\"0\" ss:Width=\"141.75\"/>
   <Column ss:StyleID=\"s63\" ss:AutoFitWidth=\"0\" ss:Width=\"53.25\"/>
   <Column ss:StyleID=\"s63\" ss:AutoFitWidth=\"0\" ss:Width=\"60.75\"/>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"15\" ss:StyleID=\"s66\">
    <Cell ss:StyleID=\"s67\"><Data ss:Type=\"String\">40.30.3.4.4 ~ ELIGIBILITY CERTIFICATE</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s63\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s63\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s63\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s63\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s63\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s63\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s63\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s63\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s63\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s63\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s63\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s63\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s63\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s70\"><Data ss:Type=\"String\">" . $year . "-" . ($year+1) . "</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"24.9375\">
    <Cell ss:StyleID=\"s71\"><Data ss:Type=\"String\">University:</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:Index=\"3\" ss:StyleID=\"s72\"><Data ss:Type=\"String\">University of Lethbridge</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s72\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s72\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s72\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s72\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s73\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s72\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"24.9375\">
    <Cell ss:StyleID=\"s71\"><Data ss:Type=\"String\">Sport:</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:Index=\"3\" ss:StyleID=\"s72\"><Data ss:Type=\"String\">" . $teamName . "</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s72\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s72\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s72\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s72\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s73\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s72\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"24.9375\">
    <Cell ss:StyleID=\"s71\"><Data ss:Type=\"String\">Year:</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:Index=\"3\" ss:StyleID=\"s72\"><Data ss:Type=\"String\">" . $year . "-" . ($year+1) . "</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s72\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s72\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s72\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s72\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s73\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s72\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
   </Row>";

$columnHeaders = "<Row ss:AutoFitHeight=\"0\" ss:Height=\"5.0625\"/>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"57.75\" ss:StyleID=\"s74\">
    <Cell ss:StyleID=\"s76\"><Data ss:Type=\"String\">Jersey&#10;No.</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s76\"><Data ss:Type=\"String\">First Name</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s76\"><Data ss:Type=\"String\">Last Name</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s76\"><Data ss:Type=\"String\">POS</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s76\"><Data ss:Type=\"String\">Height</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s76\"><Data ss:Type=\"String\">Wt</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s76\"><Data ss:Type=\"String\">Current Year of Eligibility</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s77\"><Data ss:Type=\"String\">Birth Date&#10;mth/day/yr</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s76\"><Data ss:Type=\"String\">Course</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s76\"><Data ss:Type=\"String\">Year of Study</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s76\"><Data ss:Type=\"String\">Home Town</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s76\"><Data ss:Type=\"String\">Prov</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s76\"><Data ss:Type=\"String\">Last Team</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s78\"><Data ss:Type=\"String\">If presently ineligible, please indicate with an “X”</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s78\"><Data ss:Type=\"String\">Expected Date of Eligibility for Transfer or Professional</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s79\"/>
   </Row>";

$docFooter = "<Row ss:AutoFitHeight=\"0\" ss:Height=\"24.9375\" ss:StyleID=\"s71\">
    <Cell><Data ss:Type=\"String\">Signature of Director of Athletics or Designate</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:Index=\"7\" ss:StyleID=\"s99\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s100\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s99\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s99\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s99\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s99\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s101\"><Data ss:Type=\"String\">Date:</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s99\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s99\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"24.9375\" ss:StyleID=\"s71\">
    <Cell><Data ss:Type=\"String\">Signature of Head Coach</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:Index=\"7\" ss:StyleID=\"s99\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s100\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s99\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s99\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s99\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s99\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s101\"><Data ss:Type=\"String\">Date:</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s99\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s99\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"24.9375\" ss:StyleID=\"s71\">
    <Cell><Data ss:Type=\"String\">Signature of Registrar or Designate</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:Index=\"7\" ss:StyleID=\"s99\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s100\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s99\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s99\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s99\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s99\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s101\"><Data ss:Type=\"String\">Date:</Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s99\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
    <Cell ss:StyleID=\"s99\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"3\" ss:StyleID=\"s102\">
    <Cell ss:Index=\"8\" ss:StyleID=\"s103\"><NamedCell ss:Name=\"Print_Area\"/></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:StyleID=\"s102\">
    <Cell ss:MergeAcross=\"14\" ss:MergeDown=\"2\" ss:StyleID=\"m97759456\"><Data
      ss:Type=\"String\">*The information collected in this form is used and disclosed by Canadian Interuniversity Sport (“CIS”) in accordance with the terms of CIS’ Student Athlete Acknowledgement Form and CIS’ Personal Information Protection Policy. For further information about CIS’ collection, use and disclosure of personal information, &#10;see our Personal Information Protection Policy at www.universitysport.ca </Data><NamedCell
      ss:Name=\"Print_Area\"/></Cell>
   </Row>
   <Row ss:StyleID=\"s102\"/>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"10.5\" ss:StyleID=\"s102\"/>
   <Row ss:StyleID=\"s102\">
    <Cell ss:Index=\"8\" ss:StyleID=\"s103\"/>
   </Row>
  </Table>
  <WorksheetOptions xmlns=\"urn:schemas-microsoft-com:office:excel\">
   <PageSetup>
    <Layout x:Orientation=\"Landscape\"/>
    <Header x:Margin=\"0\"/>
    <Footer x:Margin=\"0\"/>
    <PageMargins x:Bottom=\"0.5\" x:Left=\"0.7\" x:Right=\"0.7\" x:Top=\"0.5\"/>
   </PageSetup>
   <Print>
    <ValidPrinterInfo/>
    <Scale>70</Scale>
    <HorizontalResolution>600</HorizontalResolution>
    <VerticalResolution>600</VerticalResolution>
   </Print>
   <PageBreakZoom>60</PageBreakZoom>
   <Selected/>
   <DoNotDisplayGridlines/>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>38</ActiveRow>
     <ActiveCol>3</ActiveCol>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
  <Sorting xmlns=\"urn:schemas-microsoft-com:office:excel\">
   <Sort>Jersey&#10;No.</Sort>
  </Sorting>
 </Worksheet>
 <Worksheet ss:Name=\"Sheet1\">
  <Table ss:ExpandedColumnCount=\"1\" ss:ExpandedRowCount=\"1\" x:FullColumns=\"1\"
   x:FullRows=\"1\">
  </Table>
  <WorksheetOptions xmlns=\"urn:schemas-microsoft-com:office:excel\">
   <PageSetup>
    <Header x:Margin=\"0.3\"/>
    <Footer x:Margin=\"0.3\"/>
    <PageMargins x:Bottom=\"0.75\" x:Left=\"0.7\" x:Right=\"0.7\" x:Top=\"0.75\"/>
   </PageSetup>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>";

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$filename.xml");
header("Pragma: no-cache");
header("Expires: 0");
print "$workbook\n$styles\n$docHeader\n$columnHeaders\n$athleteRows\n$docFooter";

?>