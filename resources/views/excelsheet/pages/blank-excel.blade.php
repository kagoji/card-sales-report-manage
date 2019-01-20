@extends('excelsheet.layout.master-excel')
@section('content')
<div class="row text-center">
	<h4 class="page-title">Southeast Bank Ltd.</h4>
	<p>Card Division, Head Office, Dhaka</p>
	<p>Sylhet Center</p>
</div>
<div class="row">
	<h4>Salary Summary Report (Sales)</h4>

	<p>Date: {{date('M D,Y')}}</p>
</div>
<div class="row">
	<table class="table table-hover table-bordered table-striped nopadding">
		<thead>
		<tr>
			<th> # </th>
			<th> Item </th>
			<th class="hidden-480"> Description </th>
			<th class="hidden-480"> Quantity </th>
			<th class="hidden-480"> Unit Cost </th>
			<th> Total </th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td> 1 </td>
			<td> Lorem </td>
			<td class="hidden-480"> Drem psum dolor </td>
			<td class="hidden-480"> 12 </td>
			<td class="hidden-480"> $35 </td>
			<td> $1152 </td>
		</tr>
		<tr>
			<td> 2 </td>
			<td> Ipsum </td>
			<td class="hidden-480"> Consectetuer adipiscing elit </td>
			<td class="hidden-480"> 21 </td>
			<td class="hidden-480"> $469 </td>
			<td> $6159 </td>
		</tr>
		<tr>
			<td> 3 </td>
			<td> Dolor </td>
			<td class="hidden-480"> Olor sit amet adipiscing eli </td>
			<td class="hidden-480"> 24 </td>
			<td class="hidden-480"> $144 </td>
			<td> $8270 </td>
		</tr>
		<tr>
			<td> 4 </td>
			<td> Sit </td>
			<td class="hidden-480"> Laoreet dolore magna </td>
			<td class="hidden-480"> 194 </td>
			<td class="hidden-480"> $317 </td>
			<td> $966 </td>
		</tr>
		</tbody>
	</table>
</div>
<div class="row" style="margin-top: 50px;">
	<div class="col-md-5">
		<p><strong>S. M. Wahiduzzaman</strong></p>
		<p>Senior Executive Officer</p>
	</div>
	<div class="col-md-6 text-right">
		<p><strong>Kazi Saiful Islam</strong></p>
		<p>Assistant Vice President</p>
	</div>
</div>
<div class="row" style="margin-top: 50px;">
	<div class="col-md-6">
		<p><strong>N. M. Firoz Kamal</strong></p>
		<p>Senior Assistant Vice President</p>
	</div>
	<div class="col-md-6 text-right">
		<p><strong>Md. Abdus Sabur Khan</strong></p>
		<p>Senior Vice President & Head of Cards</p>
	</div>
</div>

@stop