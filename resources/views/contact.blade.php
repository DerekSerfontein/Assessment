<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<h3 class="text-center">Contact Form</h3>
<div class="col-sm-4 mx-auto">
    <div class="container">
        <div class="row justify-content-center">
            <form action="{{ route('contact.submit')}}" method="post" class="border p-5 rounded-2">
                @csrf
                @if(session('success'))
                        <div class="alert alert-success text-center">
                            {{ session('success') }}
                        </div>
                @endif
                <!-- name -->
                <div class="mb-3">
                    <label class="form-label" for="name">Name</label>
                    <input type="text" name="name" placeholder="Enter Name" value="{{ old('name')}}" class="form-control">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- email -->
                <div class="mb-3">
                    <label class="form-label" for="email">E-mail</label>
                    <input type="text" value="{{ old('email')}}" name="email" placeholder="Enter E-mail" class="form-control">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- message -->
                <div class="mb-3">
                    <label class="form-label" for="message">Message</label>
                    <textarea class="form-control" name="message" placeholder="Enter Message">{{ old('message')}}</textarea>
                    @error('message')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- submit -->
                <div class="text-center">
                    <input type="submit" name="submit" value="submit" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
