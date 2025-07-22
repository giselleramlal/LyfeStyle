namespace App\Http\Controllers;

use App\Models\Habit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HabitController extends Controller
{
    public function index()
    {
        $habits = Habit::where('user_id', auth()->id())->get();
        return Inertia::render('Habits/Index', ['habits' => $habits]);
    }

    public function store(Request $request)
    {
        Habit::create($request->merge(['user_id' => auth()->id()])->all());
        return redirect()->back()->with('success', 'Habit added.');
    }

    public function update(Request $request, $id)
    {
        Habit::where('user_id', auth()->id())->findOrFail($id)->update($request->all());
        return redirect()->back()->with('success', 'Habit updated.');
    }

    public function destroy($id)
    {
        Habit::where('user_id', auth()->id())->findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Habit deleted.');
    }
}
