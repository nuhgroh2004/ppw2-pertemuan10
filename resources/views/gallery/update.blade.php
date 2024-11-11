<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<body class="min-h-screen bg-gray-100">
<div class="flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-8 max-w-lg w-full overflow-y-auto mt-5 mb-5">
        <h2 class="text-2xl font-bold mb-6 text-gray-700">Update Gallery</h2>

        <form action="{{ route('gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-gray-600 font-medium mb-2">Title</label>
                <input type="text" name="title" class="form-input w-full border border-gray-300 rounded p-2" value="{{ $gallery->title }}" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-600 font-medium mb-2">Description</label>
                <textarea name="description" class="form-textarea w-full border border-gray-300 rounded p-2" required>{{ $gallery->description }}</textarea>
            </div>

            <div class="mb-4">
                <label for="picture" class="block text-gray-600 font-medium mb-2">Image</label>
                <input type="file" name="picture" class="form-input w-full border border-gray-300 rounded p-2">
                @if($gallery->picture)
                    <img src="{{ asset('storage/posts_image/' . $gallery->picture) }}" alt="{{ $gallery->title }}" class="mt-4 w-32 h-32 object-cover rounded-lg border border-gray-300">
                @endif
            </div>

            <div class="flex items-center justify-between mt-6">
                <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">Update Gallery</button>
                <a href="{{ route('gallery.index') }}" class="text-red-500 hover:text-red-600 font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>
</body>
