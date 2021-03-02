<?php


namespace App\Http\Controllers\Api\V1\Auth;


use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends ApiController
{
    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Enter a correct email address!ُ',
                'errors' => $validator->errors(),
                'status_code' => 422
            ], 422);
        }

        //$this->validateEmail($request);
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );
        return $response == Password::RESET_LINK_SENT
            ? $this->respond(['message' => 'The reset password link has been sent to your email.'])
            : $this->respondUnProcessableEntity('The reset link could not send, please try again later!');
    }
}
