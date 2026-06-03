<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Library\Enum;
use App\Models\Config;
use App\Library\Helper;
use App\Library\Response;
use App\Mail\DefaultMail;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Http\Traits\ApiResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\ConfigService;
use App\Http\Requests\Admin\Config\SocialLinkRequest;
use App\Http\Requests\Admin\Config\EmailSettingsRequest;
use App\Http\Requests\Admin\EmailTemplates\UpdateRequest;

class ConfigController extends Controller
{
    use ApiResponse;
    private $config_service;

    public function __construct(ConfigService $config_service)
    {
        $this->config_service = $config_service;
    }

    public function dropdownMenu()
    {
        return view('admin.pages.config.dropdown.list');
    }

    public function dropdowns($dropdown)
    {
        $values = $this->config_service::getDropdown($dropdown);

        return view('admin.pages.config.dropdown.index', [
            'dropdown' => $dropdown,
            'data'     => $values
        ]);
    }

    public function createDropdownApi(Request $request, $dropdown)
    {
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $values = $this->config_service::getDropdown($dropdown);

        if (in_array($request->name, $values)) {
            return Response::error(__($request->name . ' already exists.'));
        }

        $values[] = $request->name;
        $result = $this->config_service->updateConfig($dropdown, json_encode($values, true));

        if ($result) {
            return $this->response($result, "Successfully Created");
        }

        return back()->withInput($request->all())->with('error', $this->config_service->message);
    }

    public function updateDropdownApi(Request $request, $dropdown, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $values = $this->config_service::getDropdown($dropdown);
        $tmp_values = $values;
        unset($tmp_values[$id]);

        if (in_array($request->name, $tmp_values)) {
            return Response::error(__($request->name . ' already exists.'));
        }

        $old_name = $values[$id];
        $values[$id] = $request->name;
        $result = $this->config_service->updateConfig($dropdown, json_encode($values, true));

        // if ($old_name != $request->name) {
        //     if ($dropdown == Enum::CONFIG_DROPDOWN_EMP_DESIGNATION) {
        //         EmployeeService::updateByDesignation($old_name, ['designation' => $request->name]);
        //     }
        // }

        if ($result) {
            return $this->response($result, $this->config_service->message);
        }

        return back()->withInput($request->all())->with('error', "Successfully Updated");
    }

    public function deleteDropdownApi($dropdown, $id)
    {
        $values = $this->config_service::getDropdown($dropdown);
        array_splice($values, intval($id), 1);

        $result = $this->config_service->updateConfig($dropdown, json_encode($values, true));

        if ($result) {
            return $this->response($result, "Successfully Deleted");
        }

        return back()->with('error', $this->config_service->message);
    }

    public function emailTemplates(Request $request)
    {
        if ($request->ajax()) {
            $data = EmailTemplate::select('*');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return Helper::hasAuthRolePermission('email_template_update') ? '<a class="btn btn2-secondary btn-sm" href="' . route('admin.config.more_settings.email_template.update', $row->id) . '"> <i class="far fa-edit"></i> Edit</a>' : '';
                })
                ->editColumn('updated_at', function ($row) {
                    return getFormattedDateTime($row->updated_at);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pages.config.email_template.index');
    }

    public function updateEmailTemplateForm(EmailTemplate $email_template)
    {
        $shortcodes = explode(',', $email_template->shortcodes);
        $systemShortCodes = Enum::systemShortcodesWithValues();

        return view('admin.pages.config.email_template.update', [
            'data'             => $email_template,
            'shortcodes'       => $shortcodes,
            'systemShortCodes' => $systemShortCodes,
        ]);
    }

    public function updateEmailTemplate(EmailTemplate $email_template, UpdateRequest $request)
    {
        $data = $request->validated();
        $email_template->update([
            'subject' => $data['subject'],
            'message' => $data['message']
        ]);

        return back()->with('success', __('Successfully Updated'));
    }

    public function emailSettings()
    {
        return view('admin.pages.config.email_settings');
    }

    public function updateEmailSettings(EmailSettingsRequest $request)
    {
        try {
            $data = $request->validated();

            $this->updateConfig($data);

            updateEnv($data);

            return back()->with('success', __('Successfully Updated'));
        } catch (Throwable $e) {
            Log::error($e->getMessage());

            return back()->with('error', __('Something went wrong! Please try again'));
        }
    }

    /**
     * Update config data
     *
     * @param array $data
     *
     * @return void
     */
    protected function updateConfig(array $data)
    {
        foreach ($data as $key => $value) {
            Config::where('key', $key)->update(['value' => $value]);
        }

        Artisan::call('cache:clear');
    }

    /**
     * Send email for testing
     *
     * @param Request $request
     */
    public function sendTestMail(Request $request)
    {
        $subject = 'Testing Email';
        $message = 'This is a test email, <br> please ignore if you are not meant to be get this email.';

        try {
            $emailDetails = [
                'email'   => $request->email,
                'subject' => $subject,
                'message' => $message,
            ];

            //(new EmailFactory())->initializeEmail($emailDetails);
            Mail::to($emailDetails['email'])->send(new DefaultMail($emailDetails['subject'], $emailDetails['message']));


            return back()->with('success', __('You will receive a test email soon'));
        } catch (Throwable $e) {
            Log::error($e->getMessage());

            return back()->with('error', __('please check your email settings'));
        }
    }

    public function socialLink()
    {
        return view('admin.pages.config.social_link');
    }

    public function updateSocialLink(SocialLinkRequest $request)
    {
        $data = $request->validated();

        $this->updateConfig($data);

        return back()->with('success', __('Successfully Updated'));
    }


    public function moreSettings()
    {
        return view('admin.pages.config.moreSettings');
    }
}
