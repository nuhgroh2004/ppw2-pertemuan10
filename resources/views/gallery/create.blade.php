<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<body class="min-h-screen bg-gray-100">
    <div class="flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-8 max-w-lg w-full">
        <h2 class="text-2xl font-bold mb-6 text-gray-700">Create New Gallery</h2>

        <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Title Field -->
            <div class="mb-4">
                <label for="title" class="block text-gray-600 font-medium mb-2">Title</label>
                <input type="text" class="form-input w-full border border-gray-300 rounded p-2" id="title" name="title" placeholder="Enter title">
                @error('title')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description Field -->
            <div class="mb-4">
                <label for="description" class="block text-gray-600 font-medium mb-2">Description</label>
                <textarea class="form-textarea w-full border border-gray-300 rounded p-2" id="description" rows="5" name="description" placeholder="Enter description"></textarea>
                @error('description')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- File Input -->
            <div class="mb-4">
                <label for="input-file" class="block text-gray-600 font-medium mb-2">File Input</label>
                <input type="file" class="form-input w-full border border-gray-300 rounded p-2" id="input-file" name="picture">
                @error('picture')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="text-center mt-6">
                <div class="flex justify-between">
                    <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">Submit</button>
                    <a href="{{ route('gallery.index') }}" class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-gray-600">Back</a>
                </div>

            </div>
        </form>
    </div>
</div>
</body>
