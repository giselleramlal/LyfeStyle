namespace App\Http\Controllers;

use App\Models\SleepLog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SleepLogController extends Controller
{
    public function index()
    {
        $logs = SleepLog::where('user_id', auth()->id())->get();
        return Inertia::render('SleepLogs/Index', ['sleepLogs' => $logs]);
    }

    public function store(Request $request)
    {
        SleepLog::create($request->merge(['user_id' => auth()->id()])->all());
        return redirect()->back()->with('success', 'Sleep log added.');
    }

    public function update(Request $request, $id)
    {
        SleepLog::where('user_id', auth()->id())->findOrFail($id)->update($request->all());
        return redirect()->back()->with('success', 'Sleep log updated.');
    }

    public function destroy($id)
    {
        SleepLog::where('user_id', auth()->id())->findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Sleep log deleted.');
    }
}
