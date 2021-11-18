<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Work;
use App\Requests\CreateWorkRequest;

class WorkController extends Controller
{
    public function index()
    {
        $works = Work::getAll();

        return $this->render('pages.home', [
            'works' => $works
        ]);
    }

    public function create()
    {
        return $this->render('pages.work-create');
    }

    public function store()
    {
        $request = new CreateWorkRequest();
        $data = $request->getBody();
        $checkValidate = $request->validate();

        if (!$checkValidate) {
            $errors = $request->getFirstErrors();
            return $this->render('pages.work-create', [
                'errors' => $errors,
                'olds' => $data
            ]);
        }

        $work = new Work();
        $work->save($data);

        return $this->redirect('/');
    }

    public function edit($params)
    {
        $work = Work::findOne(
            ['id' => $params['id']],
            ['id', 'work_name', 'starting_date', 'ending_date', 'status']
        );

        if (!$work) return $this->abort('pages._404');
        
        return $this->render('pages.work-edit', [
            'work' => $work
        ]);
    }

    public function update($params)
    {
        $request = new CreateWorkRequest();
        $data = $request->getBody();
        $checkValidate = $request->validate();

        if (!$checkValidate) {
            $errors = $request->getFirstErrors();
            $this->setFlash('olds', $data);
            $this->setFlash('errors', $errors);
            return $this->redirect('/work/'.$params['id'].'/edit');
        }

        $workClass = new Work();
        $work = $workClass->findOne(
            ['id' => $params['id']],
            ['id', 'work_name', 'starting_date', 'ending_date', 'status']
        );

        if (!$work) return $this->abort('pages._404');

        $workClass->update($data, $work->id);
        
        return $this->redirect('/');
    }

    public function delete($params)
    {
        $workClass = new Work();
        $work = $workClass->findOne(
            ['id' => $params['id']]
        );

        if (!$work) return $this->abort('pages._404');

        $workClass->update([
            'deleted_at' => date('Y-m-d H:i:s')
        ], $work->id);

        return $this->redirect('/');
    }

    public function showCalendar()
    {
        $works = Work::getAll();

        return $this->render('pages.calendar', [
            'works' => $works
        ]);
    }
}
