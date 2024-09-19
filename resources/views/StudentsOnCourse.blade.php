<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Students on course</title>
</head>
<body>
    <h1>List of students related to the {{$course}} course </h1>
    <table class="table table-striped w-50" >
  <thead>
    <tr>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($students as $student)  
    <tr>  
      <td >{{$student->first_name}}</td>
      <td >{{$student->last_name}}</td>   
    </tr>
    @endforeach
</tbody>
</table>
</body>
</html>