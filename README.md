> This place is disgusting.... You need a decorator up in here!

## What It Is

A simple decorator library which allows you to remove a lot of data retrieval from your controllers and unnecessary logic from your views. It gives you one place to retrieve and prep data which drastically cleans up your controllers and views. This means:

* No more mucking up your controllers with calls to your model to retrieve data.
* No more conditionals in your views to see if certain attributes are set or not.

## How It Works

Create the directory `application/decorators` and place a file in there for each data type you want to have a decorator for. Chances are you will want to have a decorator for each model. Make sure to add the `_decorator` extension to the file name.

**File Name:** `application/decorators/user_decorator.php`

Inside the decorator, add methods for retrieving and prepping data.

	class Users_decorator extends CI_Decorator {

		public function __construct()
		{
			parent::__construct();

			$this->load->model('user_model');
		}
		
		public function info($user_id)
		{
			$user = $this->user_model->find($user_id);

			if ($user->name == '') $user->name = 'N/A';
			if ($user->email == '') $user->email = 'None';
			if ($user->phone == '') $user->phone = 'None';

			$view_data->user = $user;

			return $view_data;
		}
	}

In your controller, make a call to the library. I have been calling it where I load my views.

	$this->load->view('users/view', $this->decorator->decorate('users', 'info', $user_id));

**Tip:** You may pass a single value as the 3rd argument as a parameter to be passed to the decorator, or you can pass an array of params.

The library will try to guess what decorator you want to call by using the controller and method requested, otherwise you can specify the decorator you want to use in the first parameter and the method in the second parameter of `decorate()` (i.e. `$this->decorator->decorate('users', 'create', $params)` will call the *create* method from the *users* decorator).

That's all there is to it!

## Future Development

If you find a bug or would like to request a feature, please submit them in the issue tracker. I haven't contributed much to the CodeIgniter community, so I'm open to suggestions on how to improve this code.

Right now it's kind of a half-baked idea that I threw together, mostly because I wanted to try creating a spark. I've been using it on a couple of my projects and it has really helped clean up my code, but I know there is a lot of room for improvement.