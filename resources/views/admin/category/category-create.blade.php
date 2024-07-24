<x-heading-component />
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Oraganization Create Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ isset($category) ? route('category.update', $category->id) : route('category.store') }}" method="POST">
                @csrf
                @if(isset($category))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ isset($category) ? $category->name : old('name') }}" required>
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($category) ? 'Update' : 'Submit' }}</button>
            </form>
        </div>
    </section>
</div>
<x-footer-component />
