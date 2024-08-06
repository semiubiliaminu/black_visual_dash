<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $news = News::latest()->paginate(10);

        return response()->json([
            "status" => 200,
            "data" => $news
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
        // return true;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        
        $news = News::create($request->all());
        
        if ($news) {
            return response()->json([
                "status" => 200,
                "data" => $news,
                "message" => "News created successfully"
            ]);
        } else {
            return response()->json([
                "status" => 500,
                "message" => "Unable to create record"
            ]);
        }        
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
        $news = News::find($id);

        if ($news) {
            return response()->json([
                'result' => 200,
                'data' => $news
            ]);
        } else {
            return response()->json([
                'result' => 404,
                'message' => 'ID does not exist'
            ]);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
         $isExist = News::find($id);

            if ($isExist) {
                $request->validate([
                    "end_year" => "required",
                    "city" => "required"
                ]);

                $newsUpdated = $isExist->update($request->all());

                if ($newsUpdated) {
                    return response()->json([
                        "status" => 200,
                        "data" => $isExist,
                        "message" => "News updated successfully"
                    ]);
                } else {
                    return response()->json([
                        'status' => 500,
                        'message' => "Error! Unable to update the record"
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => "ID does not exist"
                ]);
            }

            
    }

        
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $news = News::find($id);

        if ($news) {
            $news->delete();
            return response()->json([
                "status" => 200,
                "data" => $news,
                "msg" => "News deleted successfully"
            ]);
        } else {
            return response()->json([
                "status" => 404,
                "msg" => "ID does not exist"
            ]);
        }

        
        
    }

    public function loadData(){
        $end_years = DB::table('news')->distinct()->orderBy('end_year','desc')->pluck('end_year');

        $topics = DB::table('news')->distinct()->orderBy('topic','desc')->pluck('topic');

        $sectors = DB::table('news')->distinct()->orderBy('sector','desc')->pluck('sector');


        //returns list of pesties
        $pests = DB::table('news')->distinct()->orderBy('pestle','desc')->pluck('pestle');

        $sources = DB::table('news')->distinct()->orderBy('source','desc')->pluck('source');

        $swots = DB::table('news')->distinct()->orderBy('swot','desc')->pluck('swot');

        $countries = DB::table('news')->distinct()->orderBy('country','desc')->pluck('country');

        $cities = DB::table('news')->distinct()->orderBy('city','desc')->pluck('city');

        if ($end_years || $sources || $swots || $countries || $cities) {
            return response()->json([
                "status" => 200,
                "data" => [
                    "end_years" => $end_years,
                    "sources" => $sources,
                    "swots" => $swots,
                    "countries" => $countries,
                    "cities" => $cities,
                    "pests" => $pests,
                    "topics" => $topics,
                    "sectors" => $sectors
                ]

            ]);
        }
        else {
            return response()->json([
                "status" => 404,
                "No records found"
            ]);
        }

        
    }

    public function insight(){

        // Intensity
            // Likelihood
            // Relevance
            // Year
            // Country
            // Topics
            // Region
            // City 
        //relevance of a topic by year

        //get the total number of country
        $country_count = News::where('country','!=','')->count();

        //count region
        $region_count = News::where('region','!=','')->count();

        //count uniue topics
        $topic_count = News::where('topic','!=','')->distinct()->count();

        //list of countries
        $country_list = News::where('country','!=','')->get();

        

        $relevances = DB::table('news')
            ->select(['end_year', 'topic', 'relevance'])
            ->groupBy(['end_year', 'topic', 'relevance'])
            // ->orderBy('end_year')
            ->take(50)
            ->get();

        //returns the topic of interest per counntry
        $topic_countries = DB::table('news')
            ->select(DB::raw('count(*) as country_count, country'))
            ->groupBy(['country'])
            ->orderBy('country_count','desc')
            ->take(10)
            ->get();
        

        //return the relevance of a topic to each country
        $topic_relevance = DB::table('news')
            ->select(['country','relevance','topic'])
            ->groupBy(['country', 'relevance','topic'])
            ->orderBy('relevance', 'desc')
        
            ->get();
        // dd($topic_relation);

        //returns sum of relevance per country
        $sum_rel_year = DB::table('news')
        ->select(DB::raw('sum(relevance) as sum_relevance, country'))
        ->groupBy(['country', 'relevance'])
        ->orderBy('sum_relevance','desc')
        ->get();

        //returns sum of the intesnity per topic
        $topic_intensity = DB::table('news')
        ->select(DB::raw('sum(intensity) as sum_intensity, topic'))
        ->groupBy(['topic', 'intensity'])
        ->orderBy('sum_intensity','desc')
        ->get();

        //relevance vs intensity
        $topic_vs_intensity = DB::table('news')
        ->select('relevance', 'intensity')
        ->groupBy(['relevance', 'intensity'])
        ->orderBy('sum_intensity','desc')
        ->limit(20)
        ->get();


        if ($country_count || $region_count || $topic_count || $country_list || $relevances || $topic_countries || $topic_relevance) {
            return response()->json([
                "status" => 200,
                "data" => [
                    "number_of_country" => $country_count,
                    "number_region" => $region_count,
                    "number_topic" => $topic_count,
                    "list_country" => $country_list,
                    "relavance_to_topic" => $relevances,
                    "topic_country" => $topic_countries,
                    "topic_relevance" => $topic_relevance,
                    "sum_relevance_country" => $sum_rel_year, //pie chart
                    "topic_intensity" => $topic_intensity, //for bar chart
                    "topic_vs_intensity" => $topic_vs_intensity //for line chart
                ]

            ]);
        }else {
            return response()->json([
                "status" => 404,
                "No records found"
            ]);
        }

    }

    public function filter(Request $request)
    {

        // if ($validate){
        $endyear = $request->input('endyear', '0');
        $topic = $request->input('topic');
        $sector = $request->input('sector');
        $pest = $request->input('pest');
        $source = $request->input('source');
        $swot = $request->input('swot');
        $country = $request->input('country');
        $city = $request->input('city');
        $relevance = $request->input('relevance');

        $query_builder = News::query();

        if (!empty($endyear)) {
            $query_builder->where('end_year', '=', $endyear);
        } else if (!empty($topic)) {
            $query_builder->orWhere('topic', '=', $topic);
        } else if (!empty($sector)) {
            $query_builder->orWhere('sector', '=', $sector);
        } else if (!empty($pest)) {
            $query_builder->orWhere('pest', '=', $pest);
        } else if (!empty($source)) {
            $query_builder->orWhere('source', '=', $source);
        } else if (!empty($swot)) {
            $query_builder->orWhere('swot', '=', $swot);
        } else if (!empty($country)) {
            $query_builder->orWhere('country', '=', $country);
        } elseif (!empty($city)) {
            $query_builder->orWhere('city', '=', $city);
        } else if (!empty($relevance)) {
            $query_builder->orWhere('relevance', '=', $relevance);
        } else {
            return response()->json([
                "status" => "404",
                'message' => "No record match your search "
            ]);
        }

        $data = $query_builder->get();
        $count_rows = count($data);
        if ($data) {
            return response()->json([
                "status" => 200,
                'count' => $count_rows,
                "data" => $data
            ]);
        }
    }
}