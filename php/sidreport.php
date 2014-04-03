<?php

/*
This file will generate a excel formatted xml file for the sid report. It expects a teamId number as well as the year for which to generate the report.
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

$yearTeamName = $year . "-" . ($year+1) . " " . $teamName . " Sports Information Roster";

//Get athlete info
$athleteQuery = "SELECT athletes.a_studentId, athletehistory.ah_jerseyNumber, athletes.a_firstName, athletes.a_lastName, athletehistory.ah_position, athletes.a_height, athletes.a_weight, athletes.a_dob, athletes.a_program, athletes.a_hometown
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
	$athleteRows .= "<Row>
    <Cell ss:StyleID=\"s116\"><Data ss:Type=\"Number\">" . $row['ah_jerseyNumber'] . "</Data></Cell>
    <Cell ss:StyleID=\"s113\"><Data ss:Type=\"String\">" . $row['a_firstName'] . " " . $row['a_lastName'] . "</Data></Cell>
    <Cell ss:StyleID=\"s117\"><Data ss:Type=\"String\">" . $row['ah_position'] . "</Data></Cell>
    <Cell ss:StyleID=\"s113\"><Data ss:Type=\"String\">" . $row['a_height'] . "</Data></Cell>
    <Cell ss:StyleID=\"s116\"><Data ss:Type=\"Number\">" . $row['a_weight'] . "</Data></Cell>
    <Cell ss:StyleID=\"s116\"><Data ss:Type=\"Number\">1</Data></Cell>
    <Cell ss:StyleID=\"s119\"><Data ss:Type=\"DateTime\">" . $row['a_dob'] . "</Data></Cell>
    <Cell ss:StyleID=\"s116\"><Data ss:Type=\"String\">" . $row['a_program'] . "</Data></Cell>
    <Cell ss:StyleID=\"s116\"><Data ss:Type=\"Number\">1</Data></Cell>
    <Cell ss:StyleID=\"s116\"><Data ss:Type=\"String\">" . $row['a_hometown'] . "</Data></Cell>
    <Cell ss:StyleID=\"s117\"><Data ss:Type=\"String\">" . getLastTeamPlayed($row['a_studentId'], $sql) . "</Data></Cell>
    </Row>";
}

//Faculty Information
$facultyQuery = "SELECT t_headCoachId, t_asstCoachId, t_managerId, t_trainerId
FROM teams
WHERE t_id = $teamId AND t_year = $year";

// echo $facultyQuery;

$facultyResult = mysqli_query($sql, $facultyQuery);

$facObj = mysqli_fetch_assoc($facultyResult);

$coachId = $facObj['t_headCoachId'];
$assCoachId = $facObj['t_asstCoachId'];
$managerId = $facObj['t_managerId'];
$trainerId = $facObj['t_trainerId'];
$coachName = "";
$assCoachName = "";
$managerName = "";
$trainerName = "";

if (!is_null($coachId) && $coachId != 0) {
	$query = "SELECT f_firstName, f_lastName FROM faculty WHERE f_studentId = $coachId";
	$result = mysqli_query($sql, $query);
	$result = mysqli_fetch_assoc($result);
	$coachName = $result['f_firstName'] . " " . $result['f_lastName'];
}

if (!is_null($assCoachId) && $assCoachId != 0) {
	$query = "SELECT f_firstName, f_lastName FROM faculty WHERE f_studentId = $assCoachId";
	$result = mysqli_query($sql, $query);
	$result = mysqli_fetch_assoc($result);
	$assCoachName = $result['f_firstName'] . " " . $result['f_lastName'];
}

if (!is_null($managerId) && $managerId != 0) {
	$query = "SELECT f_firstName, f_lastName FROM faculty WHERE f_studentId = $managerId";
	$result = mysqli_query($sql, $query);
	$result = mysqli_fetch_assoc($result);
	$managerName = $result['f_firstName'] . " " . $result['f_lastName'];
}

if (!is_null($trainerId) && $trainerId != 0) {
	$query = "SELECT f_firstName, f_lastName FROM faculty WHERE f_studentId = $trainerId";
	$result = mysqli_query($sql, $query);
	$result = mysqli_fetch_assoc($result);
	$trainerName = $result['f_firstName'] . " " . $result['f_lastName'];
}


$faculty = "<Row>
    <Cell ss:StyleID=\"s88\"><Data ss:Type=\"String\">Head Coach: " . $coachName . " " . "(" . getYearsCoach($coachId, $teamId, $year, $sql) . " years as coach)" . "</Data></Cell>
   </Row>
   <Row>
    <Cell ss:StyleID=\"s88\"><Data ss:Type=\"String\">Assistant Coach: " . $assCoachName . "</Data></Cell>
   </Row>
   <Row>
    <Cell ss:StyleID=\"s88\"><Data ss:Type=\"String\">Athletic Trainer: " . $trainerName . "</Data></Cell>
   </Row>
   <Row>
    <Cell ss:StyleID=\"s88\"><Data ss:Type=\"String\">Student Trainer: </Data></Cell>
   </Row>
   <Row>
    <Cell ss:StyleID=\"s88\"><Data ss:Type=\"String\">Manager: " . $managerName . "</Data></Cell>
   </Row>";

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
  <WindowHeight>11790</WindowHeight>
  <WindowWidth>15135</WindowWidth>
  <WindowTopX>1620</WindowTopX>
  <WindowTopY>45</WindowTopY>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
 </ExcelWorkbook>";

$styles =  "<Styles>
  <Style ss:ID=\"Default\" ss:Name=\"Normal\">
   <Alignment ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Calibri\" x:Family=\"Swiss\" ss:Size=\"11\" ss:Color=\"#000000\"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s57\" ss:Name=\"Normal 2 2\">
   <Alignment ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Color=\"#000000\"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s59\">
   <Alignment ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Color=\"#000000\"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s60\" ss:Name=\"Normal 3 2\">
   <Alignment ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Color=\"#000000\"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s66\" ss:Name=\"Normal 5\">
   <Alignment ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s68\" ss:Name=\"Normal 6\">
   <Alignment ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s71\" ss:Name=\"Normal 7\">
   <Alignment ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" ss:Color=\"#000000\"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s78\">
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
  <Style ss:ID=\"s79\">
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
  <Style ss:ID=\"s80\">
   <Font ss:FontName=\"Verdana\" x:Family=\"Swiss\" ss:Bold=\"1\"/>
  </Style>
  <Style ss:ID=\"s81\">
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Bold=\"1\"/>
  </Style>
  <Style ss:ID=\"s82\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <NumberFormat ss:Format=\"@\"/>
  </Style>
  <Style ss:ID=\"s83\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Bottom\"/>
  </Style>
  <Style ss:ID=\"s84\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Geneva\"/>
  </Style>
  <Style ss:ID=\"s85\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Geneva\" ss:Bold=\"1\"/>
  </Style>
  <Style ss:ID=\"s86\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Geneva\" ss:Bold=\"1\"/>
   <NumberFormat ss:Format=\"@\"/>
  </Style>
  <Style ss:ID=\"s87\">
   <Borders/>
  </Style>
  <Style ss:ID=\"s88\">
   <NumberFormat ss:Format=\"@\"/>
  </Style>
  <Style ss:ID=\"s89\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Bottom\"/>
   <NumberFormat ss:Format=\"@\"/>
  </Style>
  <Style ss:ID=\"s90\">
   <NumberFormat ss:Format=\"mm/dd/yy\"/>
  </Style>
  <Style ss:ID=\"s91\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <NumberFormat ss:Format=\"mm/dd/yy\"/>
  </Style>
  <Style ss:ID=\"s92\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Bottom\" ss:WrapText=\"1\"/>
   <Borders/>
   <Font ss:FontName=\"Geneva\" ss:Bold=\"1\"/>
   <NumberFormat ss:Format=\"mm/dd/yy\"/>
  </Style>
  <Style ss:ID=\"s93\" ss:Parent=\"s59\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s94\" ss:Parent=\"s59\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s95\" ss:Parent=\"s59\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior/>
   <NumberFormat ss:Format=\"dd\-mmm\-yy\"/>
  </Style>
  <Style ss:ID=\"s96\">
   <NumberFormat/>
  </Style>
  <Style ss:ID=\"s97\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <NumberFormat/>
  </Style>
  <Style ss:ID=\"s98\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Geneva\" ss:Bold=\"1\"/>
   <NumberFormat/>
  </Style>
  <Style ss:ID=\"s99\" ss:Parent=\"s59\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior/>
   <NumberFormat/>
  </Style>
  <Style ss:ID=\"s100\" ss:Parent=\"s59\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior/>
   <NumberFormat ss:Format=\"mm/dd/yy\"/>
  </Style>
  <Style ss:ID=\"s101\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Bottom\"/>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s102\" ss:Parent=\"s60\">
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
  <Style ss:ID=\"s103\" ss:Parent=\"s60\">
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
  <Style ss:ID=\"s104\" ss:Parent=\"s59\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior/>
   <NumberFormat ss:Format=\"Medium Date\"/>
  </Style>
  <Style ss:ID=\"s105\">
   <Borders/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s106\" ss:Parent=\"s57\">
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
  <Style ss:ID=\"s107\">
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Calibri\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
  </Style>
  <Style ss:ID=\"s108\">
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
  </Style>
  <Style ss:ID=\"s109\" ss:Parent=\"s66\">
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\"/>
  </Style>
  <Style ss:ID=\"s110\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior/>
   <NumberFormat ss:Format=\"mm/dd/yy\"/>
  </Style>
  <Style ss:ID=\"s111\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Bottom\"/>
   <NumberFormat ss:Format=\"Medium Date\"/>
  </Style>
  <Style ss:ID=\"s112\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Bottom\"/>
   <NumberFormat ss:Format=\"Short Date\"/>
  </Style>
  <Style ss:ID=\"s113\" ss:Parent=\"s68\">
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\"/>
  </Style>
  <Style ss:ID=\"s114\" ss:Parent=\"s68\">
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\"/>
   <NumberFormat ss:Format=\"@\"/>
  </Style>
  <Style ss:ID=\"s115\" ss:Parent=\"s71\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
  </Style>
  <Style ss:ID=\"s116\" ss:Parent=\"s71\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Arial\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s117\" ss:Parent=\"s71\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Bottom\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Arial\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s118\" ss:Parent=\"s71\">
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
  <Style ss:ID=\"s119\" ss:Parent=\"s71\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Arial\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior/>
   <NumberFormat ss:Format=\"mm/dd/yy;@\"/>
  </Style>
  <Style ss:ID=\"s120\" ss:Parent=\"s71\">
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
 </Styles>
 <Worksheet ss:Name=\"Sheet1\">
  <Table ss:ExpandedColumnCount=\"13\" ss:ExpandedRowCount=\"46\" x:FullColumns=\"1\"
   x:FullRows=\"1\" ss:DefaultRowHeight=\"15\">
   <Column ss:Index=\"2\" ss:AutoFitWidth=\"0\" ss:Width=\"102.75\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"59.25\"/>
   <Column ss:StyleID=\"s96\" ss:AutoFitWidth=\"0\"/>
   <Column ss:Index=\"7\" ss:StyleID=\"s90\" ss:AutoFitWidth=\"0\" ss:Width=\"58.5\"/>
   <Column ss:StyleID=\"s83\" ss:AutoFitWidth=\"0\" ss:Width=\"84.75\"/>
   <Column ss:StyleID=\"s83\" ss:AutoFitWidth=\"0\"/>
   <Column ss:StyleID=\"s83\" ss:AutoFitWidth=\"0\" ss:Width=\"91.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"158.25\"/>
   <Row>
    <Cell ss:StyleID=\"s80\"><Data ss:Type=\"String\">University of Lethbridge</Data></Cell>
   </Row>
   <Row>
    <Cell ss:StyleID=\"s81\"><Data ss:Type=\"String\">" . $yearTeamName . "</Data></Cell>
    <Cell ss:Index=\"4\" ss:StyleID=\"s97\"/>
    <Cell ss:StyleID=\"s82\"/>
    <Cell ss:StyleID=\"s82\"/>
    <Cell ss:StyleID=\"s91\"/>
    <Cell ss:StyleID=\"s89\"/>
    <Cell ss:StyleID=\"s89\"/>
    <Cell ss:Index=\"11\" ss:StyleID=\"s83\"/>
    <Cell ss:StyleID=\"s83\"/>
   </Row>
   <Row>
    <Cell ss:StyleID=\"s81\"/>
    <Cell ss:Index=\"4\" ss:StyleID=\"s97\"/>
    <Cell ss:StyleID=\"s82\"/>
    <Cell ss:StyleID=\"s82\"/>
    <Cell ss:StyleID=\"s91\"/>
    <Cell ss:StyleID=\"s89\"/>
    <Cell ss:StyleID=\"s89\"/>
    <Cell ss:Index=\"11\" ss:StyleID=\"s83\"/>
    <Cell ss:StyleID=\"s83\"/>
   </Row>
   <Row ss:Height=\"24.75\">
    <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">#</Data></Cell>
    <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">Name</Data></Cell>
    <Cell ss:StyleID=\"s86\"><Data ss:Type=\"String\">Pos</Data></Cell>
    <Cell ss:StyleID=\"s98\"><Data ss:Type=\"String\">Ht</Data></Cell>
    <Cell ss:StyleID=\"s86\"><Data ss:Type=\"String\">Wt</Data></Cell>
    <Cell ss:StyleID=\"s86\"><Data ss:Type=\"String\">Elig</Data></Cell>
    <Cell ss:StyleID=\"s92\"><ss:Data ss:Type=\"String\"
      xmlns=\"http://www.w3.org/TR/REC-html40\"><B>DOB <Font html:Size=\"8\">(mm/dd/yy)</Font></B></ss:Data></Cell>
    <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">Major</Data></Cell>
    <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">Yr</Data></Cell>
    <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">Hometown</Data></Cell>
    <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">Previous Team</Data></Cell>
    <Cell ss:StyleID=\"s87\"/>
   </Row>";

 $footer =  "<Row>
    <Cell ss:Index=\"4\" ss:StyleID=\"Default\"/>
    <Cell ss:StyleID=\"s96\"/>
    <Cell ss:Index=\"7\" ss:StyleID=\"Default\"/>
    <Cell ss:StyleID=\"s90\"/>
    <Cell ss:StyleID=\"s111\"/>
    <Cell ss:Index=\"11\" ss:StyleID=\"s83\"/>
   </Row>
   <Row>
    <Cell ss:Index=\"9\" ss:StyleID=\"s112\"/>
    <Cell ss:Index=\"13\" ss:StyleID=\"s105\"/>
   </Row>
   <Row>
    <Cell ss:Index=\"13\" ss:StyleID=\"s94\"/>
   </Row>
   <Row>
    <Cell ss:StyleID=\"s93\"/>
    <Cell ss:StyleID=\"s94\"/>
    <Cell ss:StyleID=\"s94\"/>
    <Cell ss:StyleID=\"s99\"/>
    <Cell ss:StyleID=\"s93\"/>
    <Cell ss:StyleID=\"s93\"/>
    <Cell ss:StyleID=\"s100\"/>
    <Cell ss:StyleID=\"s95\"/>
    <Cell ss:StyleID=\"s104\"/>
    <Cell ss:StyleID=\"s93\"/>
    <Cell ss:StyleID=\"s93\"/>
    <Cell ss:Index=\"13\" ss:StyleID=\"s94\"/>
   </Row>
   <Row>
    <Cell ss:Index=\"13\" ss:StyleID=\"s87\"/>
   </Row>
  </Table>
  <WorksheetOptions xmlns=\"urn:schemas-microsoft-com:office:excel\">
   <PageSetup>
    <Layout x:Orientation=\"Landscape\"/>
    <Header x:Margin=\"0.3\"/>
    <Footer x:Margin=\"0.3\"/>
    <PageMargins x:Bottom=\"0.75\" x:Left=\"0.7\" x:Right=\"0.7\" x:Top=\"0.75\"/>
   </PageSetup>
   <Print>
    <ValidPrinterInfo/>
    <Scale>78</Scale>
    <HorizontalResolution>600</HorizontalResolution>
    <VerticalResolution>600</VerticalResolution>
   </Print>
   <PageBreakZoom>60</PageBreakZoom>
   <Selected/>
   <TopRowVisible>9</TopRowVisible>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>23</ActiveRow>
     <ActiveCol>12</ActiveCol>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
  <Sorting xmlns=\"urn:schemas-microsoft-com:office:excel\">
   <Sort>6</Sort>
  </Sorting>
 </Worksheet>
 <Worksheet ss:Name=\"Sheet2\">
  <Table ss:ExpandedColumnCount=\"1\" ss:ExpandedRowCount=\"1\" x:FullColumns=\"1\"
   x:FullRows=\"1\" ss:DefaultRowHeight=\"15\">
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
 <Worksheet ss:Name=\"Sheet3\">
  <Table ss:ExpandedColumnCount=\"1\" ss:ExpandedRowCount=\"1\" x:FullColumns=\"1\"
   x:FullRows=\"1\" ss:DefaultRowHeight=\"15\">
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
print "$workbook\n$styles\n$athleteRows\n$faculty\n$footer";

?>