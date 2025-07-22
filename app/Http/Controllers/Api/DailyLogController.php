use Inertia\Inertia;
use App\Models\DailyLog;
use Illuminate\Http\Request;

class DailyLogController extends Controller
{
    <!-- public function index()
    {
        $logs = DailyLog::where('user_id', auth()->id())->get();
        return Inertia::render('DailyLogs/Index', ['logs' => $logs]);
    } -->

    public function index()
{
    return response()->json(['message' => 'Route working!']);
}


    public function store(Request $request)
    {
        DailyLog::updateOrCreate(
            ['user_id' => auth()->id(), 'date' => $request->date],
            $request->all()
        );
        return redirect()->back()->with('success', 'Daily log saved.');
    }

    public function update(Request $request, $id)
    {
        DailyLog::where('user_id', auth()->id())->findOrFail($id)->update($request->all());
        return redirect()->back()->with('success', 'Daily log updated.');
    }

    public function destroy($id)
    {
        DailyLog::where('user_id', auth()->id())->findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Daily log deleted.');
    }
}
