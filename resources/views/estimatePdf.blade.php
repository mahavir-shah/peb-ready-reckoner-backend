<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h2>Estimate</h2>

<table>
  <tr>
    <td>Project Name</td>
    <td>{{$project_name}}</td>
  </tr>
  <tr>
    <td>Location</td>
    <td>{{$project_location}}</td>
  </tr>
  <tr>
    <td>Type of Frame</td>
    <td>{{$type_of_frame}}</td>
  </tr>
  <tr>
    <td>Code of Design</td>
    <td>{{$code_of_design == 1 ? 'IS 800:2007' : 'AISC 360'}}</td>
  </tr>
  <tr>
    <td>Wind Speed (m/s)</td>
    <td>{{$wind_speed}}</td>
  </tr>
  <tr>
    <td>Bay span (m)</td>
    <td>{{$span}}</td>
  </tr>
  <tr>
    <td>c/c span of Frame (m)</td>
    <td>{{$width}}</td>
  </tr>
  <tr>
    <td>Eave height (m)</td>
    <td>{{$height}}</td>
  </tr>
  <tr>
    <td>Length Of Building (m)</td>
    <td>{{$length_of_building}}</td>
  </tr>
</table>

<table style="margin-top:20px;">
<tr>
    <th>Result</th>
    <th>(Kg/m2)</th>
    <th>Kg</th>
  </tr>
  <tr>
    <td>Main frame steel</td>
    <td>{{$main_frame_steel_m2}}</td>
    <td>{{number_format($main_frame_steel_kg)}}</td>
  </tr>
  <tr>
    <td>Top purlin</td>
    <td>{{$top_purlin_m2}}</td>
    <td>{{number_format($top_purlin_kg)}}</td>
  </tr>
  <tr>
    <td>Side wall girt</td>
    <td>{{$side_wall_girt_m2}}</td>
    <td>{{number_format($side_wall_girt_kg)}}</td>
  </tr>
  <tr>
    <td>Gable end girt</td>
    <td>{{$gable_end_girt_m2}}</td>
    <td>{{number_format($gable_end_girt_kg)}}</td>
  </tr>
  <tr>
    <td>Roofing Sheet</td>
    <td>{{$roofing_sheet_m2}}</td>
    <td>{{number_format($roofing_sheet_kg)}}</td>
  </tr>
  <tr>
    <td>Cladding Sheet</td>
    <td>{{$clading_sheet_m2}}</td>
    <td>{{number_format($clading_sheet_kg)}}</td>
  </tr>
  <tr>
    <td>Sag Rod</td>
    <td>{{$sag_rod_m2}}</td>
    <td>{{number_format($sag_rod_kg)}}</td>
  </tr>
  <tr>
    <td>Flange Brace</td>
    <td>{{$stay_brace_m2}}</td>
    <td>{{number_format($stay_brace_kg)}}</td>
  </tr>
  <tr>
    <td>Anchor bolt</td>
    <td>{{$anchor_bolt_m2}}</td>
    <td>{{number_format($anchor_bolt_kg)}}</td>
  </tr>
  <tr>
    <td>Purlin Clear</td>
    <td>{{$cleat_m2}}</td>
    <td>{{number_format($cleat_kg)}}</td>
  </tr>
  <tr>
    <td>X-Bracing</td>
    <td>{{$x_bracing_m2}}</td>
    <td>{{number_format($x_bracing_kg)}}</td>
  </tr>
  <tr>
    <td>Tie Strut</td>
    <td>{{$tie_strut_m2}}</td>
    <td>{{number_format($tie_strut_kg)}}</td>
  </tr>
  <tr>
    <td>Finishing</td>
    <td>{{$finishing_m2}}</td>
    <td>{{number_format($finishing_kg)}}</td>
  </tr>
  @if($gantry_girder_in_all_days == 1)
  <tr>
    <td>Gantry Girder</td>
    <td>{{$gantry_girder_m2}}</td>
    <td>{{number_format($gantry_girder_kg)}}</td>
  </tr>
  @endif
  <tr>
    <td>Total Quantity @if($gantry_girder_in_all_days == 1) with @else without @endif gantry</td>
    <td>{{$total_quantity_m2}}</td>
    <td>{{number_format($atotal_quantity_kg)}}</td>
  </tr>
</table>

</body>
</html>

