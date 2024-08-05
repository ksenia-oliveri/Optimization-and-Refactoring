<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title></title>
</head>
<body>
<form action= '{{route('find.groups') }}' method="GET" class="p-2" >
  <div class="form-group">
    <label>Find groups with less or equals student count</label>
    <input type="number" class="form-control" name="number" placeholder="Enter number of students">
    <input type='submit' class="btn btn-primary mt-2" value="Search">
  </div>
</form>
<form action=" {{route('find.students') }}" method="GET" class="p-2">
  <div class="form-group">
    <label>Find students related to the course</label>
    <input type="text" class="form-control" name='search' placeholder="Enter course name">
    <input type="submit" class="btn btn-primary mt-2" value="Search" >
  </div>
</form>
<form action="{{ route('add.student') }}" method="POST" class="p-2">
  @csrf
<div class=" form-group">
    <label>Add new student</label>
        <div class="form-row">
            <div class="col">
                <input type="text" class="form-control" name= 'first_name' placeholder="First name">
                @error('first_name')
                <div class="text-danger">Please complete this required field</div>
                @enderror
            </div>
            <div class="col">
                <input type="text" class="form-control" name="last_name" placeholder="Last name">
                @error('last_name')
                <div class="text-danger">Please complete this required field</div>
                @enderror
            </div>
        </div>
    <input type= 'submit' class="btn btn-primary mt-2" value="Add">
</div>
</form>
<form action="{{route('delete.student')}}" method="POST" class="p-2">
  @csrf
  @method('DELETE')
<div class="form-group">
    <label>Delete student by STUDENT_ID</label>
    <input type="number" class="form-control" name="student_id" placeholder="Enter student ID">
    <input type="submit" class="btn btn-primary mt-2" value="Delete">
</div>
</form>
<div class="p-2">
  <p>Show all students and their courses</p>
  <a href="{{route('get.all.students.courses')}}">
  <button type="button" class="btn btn-link">Show</button>
  </a>
</div>   
</body>
</html>