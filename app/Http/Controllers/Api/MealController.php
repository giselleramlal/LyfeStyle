use Inertia\Inertia;
use App\Models\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function index()
    {
        $meals = Meal::where('user_id', auth()->id())->get();
        return Inertia::render('Meals/Index', ['meals' => $meals]);
    }

    public function store(Request $request)
    {
        Meal::create($request->merge(['user_id' => auth()->id()])->all());
        return redirect()->back()->with('success', 'Meal added.');
    }

    public function update(Request $request, $id)
    {
        Meal::where('user_id', auth()->id())->findOrFail($id)->update($request->all());
        return redirect()->back()->with('success', 'Meal updated.');
    }

    public function destroy($id)
    {
        Meal::where('user_id', auth()->id())->findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Meal deleted.');
    }
}
