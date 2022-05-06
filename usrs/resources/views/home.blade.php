<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <div class="container m-3 p-2">
        <form method="post" action="login">
            @csrf
            <div class="form-group p-3">
            <input type="text" value="{{old('username')}}" name="username" class="form-control" placeholder="username">
            <span class="text-danger">@error('username') {{$message}} @enderror</span>

            <input type="password" name="password" class="form-control" placeholder="**********">
<span class="text-danger">@error('password') {{$message}} @enderror</span><br>
            <button type="submit" class="bg-success text-light border border-success m-2">Login</button>

            </div>
        </form>
    </div>
</body>
</html>
