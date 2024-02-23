

<!-- Signin Form -->
<form action="{{ route('login') }}" method="POST" class="space-y-4 mt-8">
    @csrf
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="text" id="email" name="email" class="mt-1 p-2 w-full border rounded-md focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300">
    </div>
    <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" id="password" name="password" class="mt-1 p-2 w-full border rounded-md focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300">
    </div>
    <div>
        <button type="submit" class="w-full bg-black text-white p-2 rounded-md hover:bg-gray-800 focus:outline-none focus:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-colors duration-300">Sign In</button>
    </div>
</form>

<div class="mt-4 text-sm text-gray-600 text-center">
    <p>Don't have an account? <a href="{{ route('register') }}" class="text-black hover:underline">Sign up here</a></p>
</div>
<a href="{{ route('password.request') }}">Forgot Password?</a>
