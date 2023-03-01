<?php

namespace App\Http\Middleware;

use App\Modules\ServiceProvider\Enums\KycStatus;
use App\Modules\ServiceProvider\Models\KycRequest;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckKyc
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $kycRequest = KycRequest::where('user_id', $request->user()->id)->first()) {
            return redirect()->route('service-provider.kyc.create');
        }

        if ($kycRequest->status->redirectToWaitingPage()) {
            return redirect()->route('service-provider.kyc.waiting');
        }

        if (! ($kycRequest->status == KycStatus::Approved)) {
            return redirect()->route('service-provider.kyc.create');
        }

        return $next($request);
    }
}
