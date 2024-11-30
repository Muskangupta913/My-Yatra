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


        public login(Request $request){
            ValidateData=$request->validate([
                'email'='require|email',
                'password'='require|min6',
                ])

                if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password])){
                    return redirect()->intended();
                }
                return back()->withErrors([
                    'email'])
        }
