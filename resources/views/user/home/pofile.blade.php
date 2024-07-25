<x-user.heading-component />

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="section-title text-center">
                <h2>My Profile Page</h2>
            </div>
            @if ($errors->isNotEmpty())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session()->has('success'))
                <div class="alert alert-success" id="flashMessage"><p>{{ session('success') }}</p></div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger" id="flashMessage"><p>{{ session('error') }}</p></div>
            @endif
            <div class="contact__form">
                <form action="{{ route('user.edit.store', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 text-center mb-4">
                            @if ($user->getFirstMediaUrl('image'))
                                <img src="{{ $user->getFirstMediaUrl('image') }}" alt="User Image" class="img-thumbnail" width="100">
                            @else
                                <p>No image</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name"><b>Name</b></label>
                                <input type="text" class="form-control" id="name" placeholder="User Name" name="name" value="{{ $user->name }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email"><b>Email</b></label>
                                <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{ $user->email }}" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="image"><b>Image</b></label>
                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="password"><b>Password</b></label>
                                <input type="password" class="form-control" id="password" placeholder="Password" name="password" value="{{ $user->password }}" readonly >
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            {{-- <a href="{{ route('recover.password') }}" class="btn btn-link">Forgot Password?</a> --}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<x-user.footer-component />
