<button class="btn btn-outline-danger rounded-0 add-to-cart" data-id="${item.id}">Add To Cart</button>





public function loginshow(){
    return view('auth.login');
}

public function login(Request $request){
   
    
    $validateData=$request->validate([
        'email'=>'require|email',
        'password'=>'require|min6,
        ]);
    
        if(Auth::attempt(['email' =>$request ->email, 'password' => $request->password], $request->remember)){
            return redirect()->intended('/dashboard');
        }
        return back()->withErrors([
            'email'=>'The provided crendentials do not match'])->withInput($request ->only('email', 'remember'))
        }
lets discusse the difference between mern stack and laravel , php so lets start from here . mern stack is a combination of react , node js , express js , mongodb 
where as php and laravel is differet language meanwhile the function of both of them is similar only the term and condition make them different is syntax of <code class="so lets disscuss each of lang"></code>

react js - it is used for building client side application ehich helps to make a website single page web application
node js - it is java script run time envirnment l
    
