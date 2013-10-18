<?php
$this->breadcrumbs=array(
	'Monthwise Student Attendance Report',	
);

?>

<?php 
//echo $en_no;
if(!empty($_REQUEST['id']))
{
echo CHtml::link('GO BACK',array('/student/attendence/StudentAttendenceReport','id'=>$_REQUEST['id']))."</br>";
}
else
{
echo CHtml::link('GO BACK',Yii::app()->createUrl('/student/attendence/studentwisereport'));

?>

<div>&nbsp;</div>
<table  border="2px" id="twoColThinTable">
<tr class="row">
	<td class="col1">Name </td>
	<td class="col2"><?php echo '<span style=text-transform:capitalize;>'.strtolower($student_data['student_first_name']).'</span>';?></td>
</tr>	
<tr class="row">	
	<td class="col1">Enrollment No. </td> 
	<td class="col2"><?php echo $student_data['student_enroll_no'];?></td>
</tr>	
<tr class="row">
	<td class="col1">Roll No. </td> 
	<td class="col2"> <?php echo $student_data['student_roll_no'];?></td>
</tr>	
<tr class="row">	
	<td class="col1">Current Semester  </td> 
	<td class="col2">
	Sem:-<?php echo AcademicTerm::model()->findByPk($student_data['student_academic_term_name_id'])->academic_term_name; ?></td>
</tr>	
<table>
<div>&nbsp;</div>
<?php 
}
echo "</br>";
$i=0;
$m=1;
//echo $start;
//echo $end;
//exit;
//print_r($subject_data);
//exit;
if($subject_data)
{
echo '<table class="table_data" >';
echo "<th colspan=\"6\" style=\"font-size: 18px; color: rgb(255, 255, 255);\">";
	echo 'Attendance Report From-Date:'.date("d-m-Y", strtotime($start))." To-Date: ".date("d-m-Y", strtotime($end));
        echo '</th><tr class="table_header"><th>SI No.</th><th>Subject Name</th><th>Semester</th><th>Total</th><th>Present</th><th>Attendance %</th></tr>';foreach($subject_data as $list) {
		if(($m%2) == 0)
		{
		  $class = "odd";
		}
		else
		{
		  $class = "even";
		}
	

			$total_att = Attendence::model()->findAll(array('condition'=>'st_id='.$student_data['student_transaction_id'].' AND sub_id='.$list['subject_master_id'].' AND month(attendence_date)='.$month_value.' AND year(attendence_date)='.$year));
			$pre_att = Attendence::model()->findAll(array('condition'=>'st_id='.$student_data['student_transaction_id'].' AND attendence="P"'.' AND sub_id='.$list['subject_master_id'].' AND month(attendence_date)='.$month_value.' AND year(attendence_date)='.$year));

		$sem_name = AcademicTerm::model()->findByPk($list['subject_master_academic_terms_name_id'])->academic_term_name;
		$percentage=0;
		$totalcount=count($total_att);
		$precount=count($pre_att);
		if(count($total_att)==0)
		{
			
			echo '<tr class='.$class.'><td>'.++$i.'</td><td><u>'.CHtml::link($list['subject_master_name'].'('.SubjectType::model()->findByPk($list['subject_master_type_id'])->subject_type_name.")",array('monthview','month'=>$month_value,'year'=>$year,'student_id'=>$student_data['student_transaction_id'],'sub_id'=>$list['subject_master_id']), array('class'=>'link','target'=>'_blank')).'</u></td><td>'.$sem_name.'</td><td>'.count($total_att).'</td><td>'.count($pre_att).'</td><td>'.$percentage.'%</td></tr>';
			
		}
		else
		{
			$percentage = (count($pre_att)*100)/count($total_att);
			echo '<tr class='.$class.'><td>'.++$i.'</td><td><u>'.CHtml::link($list['subject_master_name'].'('.SubjectType::model()->findByPk($list['subject_master_type_id'])->subject_type_name.")",array('monthview','month'=>$month_value,'year'=>$year,'student_id'=>$student_data['student_transaction_id'],'sub_id'=>$list['subject_master_id']), array('class'=>'link','target'=>'_blank')).'</u></td><td>'.$sem_name.'</td><td>'.count($total_att).'</td><td>'.count($pre_att).'</td><td>'.round($percentage,2).'%</td></tr>';

			
		}
		
$m++;		
	
}
echo '</table>';
}
else
{
	print  "<h1 style=\"color:red;text-align:center\">No Record To Display</h1>";

}


?>
