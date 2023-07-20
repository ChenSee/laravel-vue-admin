<?php

namespace SmallRuralDog\Admin\Controllers;

use SmallRuralDog\Admin\Components\Form\Input;
use SmallRuralDog\Admin\Components\Form\Upload;
use SmallRuralDog\Admin\Form;
use SmallRuralDog\Admin\Layout\Row;
use SmallRuralDog\Admin\Layout\Content;

class SettingController extends AdminController
{
    public function index(Content $content)
    {
        $content->body($this->form(true)->edit(auth(config('admin.auth.guard'))->id()))->className("p-10");
        return $this->isGetData() ? $this->form(true)->edit(auth(config('admin.auth.guard'))->id()) : $content;
    }

    public function editUpdate()
    {
        return $this->update(auth(config('admin.auth.guard'))->id());
    }

    protected function form()
    {
        $userModel = config('admin.database.users_model');
        $form = new Form(new $userModel());

        $userTable = config('admin.database.users_table');
        $connection = config('admin.database.connection');


        $form->item('avatar', '头像')->component(Upload::make()->avatar()->path('avatar')->uniqueName());
        $form->row(function (Row $row, Form $form) use ($userTable, $connection) {
            $row->column(8, $form->rowItem('username', '用户名')
                ->serveCreationRules(['required', "unique:{$connection}.{$userTable}"])
                ->serveUpdateRules(['required', "unique:{$connection}.{$userTable},username,{{id}}"])
                ->component(Input::make())->required());
            $row->column(8, $form->rowItem('name', '名称')->component(Input::make()->showWordLimit()->maxlength(20))->required());
        });

        $form->row(function (Row $row, Form $form) {
            $row->column(8, $form->rowItem('password', '密码')->serveCreationRules(['required', 'string', 'confirmed'])->serveUpdateRules(['confirmed'])->ignoreEmpty()
                ->component(function () {
                    return Input::make()->password()->showPassword();
                }));

            $row->column(8, $form->rowItem('password_confirmation', '确认密码')
                ->copyValue('password')->ignoreEmpty()
                ->component(function () {
                    return Input::make()->password()->showPassword();
                }));
        });

        $form->actions(function (Form\FormActions $formActions) {
            $formActions->hideCancelButton();
            $formActions->submitButton()->content("保存");
        });

        $form->action('/admin-api/auth/setting');
        $form->successRefData("", "");
        $form->saving(function (Form $form) {
            if ($form->password) {
                $form->password = bcrypt($form->password);
            }
        });

        return $form;
    }
}
