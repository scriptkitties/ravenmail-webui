@extends('main')

@section('content')
<h2>Terms of Service</h2>
<p>
    By using this service, you agree to the following Terms of Service.
</p>

<h2>Warranty</h2>
<p>
    This service is provided by the {{ config('app.name') }} staff and
    contributors "as is" and any express or implied warranties, including, but
    not limited to, the implied warranties of merchantability and fitness for a
    particular purpose are disclaimed. In no event shall {{ config('app.name')
    }} or contributors be liable for any direct, indirect, incidental, special,
    exemplary, or consequential damages (including, but not limited to,
    procurement of substitute goods or services; loss of use, data, or profits;
    or business interruption) however caused and on any theory of liability,
    whether in contract, strict liability, or tort (including negligence or
    otherwise) arising in any way out of the use of this software, even if
    advised of the possibility of such damage.
</p>

<h2>Intellectual ownership</h2>
<p>
    All content sent through the {{ config('app.name') }} network is ownership
    of their respective account owners. Messages sent through the network do
    not necessarily portray the opinion of the staff or contributors.
</p>

<h2>Termination of your account</h2>
<p>
    The following actions will get your account terminated. Do note that this
    list is not definitive, and {{ config('app.name') }} staff holds the right
    to terminate your account at any point in time, for any reason, without
    prior notice.
</p>
<ul>
    <li>Sending spam</li>
    <li>Using the {{ config('app.name') }} service to abuse other services</li>
    <li>Using the {{ config('app.name') }} service to break the law</li>
    <li>Encourage others to break the rules of this service</li>
    <li>Encourage others to break a law</li>
    <li>Attempt to find or abuse bugs in the service without permission</li>
</ul>
@endsection

