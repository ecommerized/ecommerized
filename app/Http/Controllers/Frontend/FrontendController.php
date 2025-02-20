<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Blog;
use App\Models\ChooseUs;
use App\Models\ContactUs;
use App\Models\Faq;
use App\Models\LandingPageSetting;
use App\Models\MembershipBenefits;
use App\Models\Package;
use App\Models\Page;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\WorkingProcess;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class FrontendController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $data['pageTitle'] = __('Welcome');
        $data['collection'] = LandingPageSetting::all();
        $data['faqData'] = Faq::where('status',STATUS_ACTIVE)->get();
        $data['aboutUs'] = AboutUs::first();
        $data['chooseUs'] = ChooseUs::where('status',STATUS_ACTIVE)->get();
        $data['serviceData'] = Service::where('status',STATUS_ACTIVE)->get();
        $data['memberBenefits'] = MembershipBenefits::where('status',STATUS_ACTIVE)->get();
        $data['portfolioCategory'] = PortfolioCategory::where('status',STATUS_ACTIVE)->get();
        $data['packageData'] = Package::where('status',STATUS_ACTIVE)->get();
        $data['portfolioData'] = Portfolio::where('status', STATUS_ACTIVE)->get()->groupBy('category_id');
        $data['testimonialData'] = Testimonial::leftJoin('testimonial_categories', 'testimonials.category_id', '=', 'testimonial_categories.id')
            ->select('testimonial_categories.name as categoryName', 'testimonials.*')
            ->where('testimonials.status', STATUS_ACTIVE)
            ->get();
        $data['blogData'] = Blog::leftjoin('blog_categories','blogs.blog_category_id','=','blog_categories.id')
            ->select('blogs.*','blog_categories.name as categoryName')
            ->get();
        if(getOption('app_theme_style') == THEME_HOME_TWO){
            $data['workingProcessData'] = WorkingProcess::where('status',STATUS_ACTIVE)->get();
        }else{
            $data['workingProcessData'] = WorkingProcess::where('status',STATUS_ACTIVE)->take(3)->get();
        }

        return view('frontend.themes.'.getPrefix().'.frontend', $data);
    }

    public function contactUs(){

        $data['activeContactUs'] = 'active';
        $data['pageTitle'] = __('Contact Us');

        return view('frontend.themes.'.getPrefix().'.contact-us',$data);
    }

    public function portfolioDetails($id){

        $data['activePortfolio'] = 'active';
        $data['pageTitle'] = __('Portfolio Details');
        $data['portfolioDetails'] = Portfolio::find(decodeId($id));

        if (!$data['portfolioDetails']) {
            $data['portfolioDetails'] = [];
        }

        return view('frontend.themes.'.getPrefix().'.portfolio-details',$data);
    }

    public function contactUsStore(Request $request) {

        $validated = $request->validate([
            "name" => ['required', 'string', 'max:255'],
            "email" => ['required', 'email', 'max:255'],
            'message' => ['required', 'string'],
        ]);


        DB::beginTransaction();
        try {
            $contactUs = new ContactUs();

            $contactUs->name = $request->name;
            $contactUs->email = $request->email;
            $contactUs->message = $request->message;

            $contactUs->save();
            DB::commit();
            return $this->success([], SENT_SUCCESSFULLY);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], SOMETHING_WENT_WRONG);
        }

    }

    public function serviceDetails($slug){

        $data['activeService'] = 'active';
        $data['pageTitle'] = __('Service Details');
        $data['collection'] = LandingPageSetting::all();
        $data['faqData'] = Faq::where('status',STATUS_ACTIVE)->get();
        $data['serviceData'] = Service::where('slug',$slug)->first();
        $data['chooseUs'] = ChooseUs::where('status',STATUS_ACTIVE)->get();

        return view('frontend.themes.'.getPrefix().'.service-details',$data);
    }

    public function blogList(){

        $data['activeBlog'] = 'active';
        $data['pageTitle'] = __('Blog List');
        $data['blogData'] = Blog::leftjoin('blog_categories','blogs.blog_category_id','=','blog_categories.id')
            ->select('blogs.*','blog_categories.name as categoryName')
            ->paginate(9);

        return view('frontend.themes.'.getPrefix().'.blog-list',$data);
    }

    public function blogDetails($slug){

        $data['activeBlog'] = 'active';
        $data['pageTitle'] = __('Blog Details');
        $data['blogDetails'] = Blog::leftjoin('users','users.id','=','blogs.created_by')
            ->leftjoin('designations','users.company_designation','=','designations.id')
            ->select('users.name','users.image','designations.title as designationTitle','blogs.*')
            ->where('blogs.slug',$slug)->first();
        $data['popularPost'] = Blog::where('blog_category_id', '=', $data['blogDetails']->blog_category_id)
            ->where('slug', '!=' ,$data['blogDetails']->slug)
            ->get();
        return view('frontend.themes.'.getPrefix().'.blog-details',$data);
    }

    public function page($slug)
    {
        $data['activePage'] = 'active';
        $data['pageTitle'] = __('Page Details');
        $data['pageData'] = Page::where('slug', $slug)->firstOrFail();

        return view('frontend.themes.'.getPrefix().'.page', $data);
    }

    public function aboutUs()
    {
        $data['activeAboutUs'] = 'active';
        $data['pageTitle'] = __('About Us');
        $data['aboutUs'] = AboutUs::first();
        $data['collection'] = LandingPageSetting::all();
        $data['faqData'] = Faq::where('status',STATUS_ACTIVE)->get();
        $data['workingProcessData'] = WorkingProcess::where('status',STATUS_ACTIVE)->get();

        return view('frontend.themes.'.getPrefix().'.about-us', $data);
    }

}
