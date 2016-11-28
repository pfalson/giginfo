<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateStateAPIRequest;
use App\Http\Requests\API\UpdateStateAPIRequest;
use App\State;
use App\Repositories\StateRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class StateController
 * @package App\Http\Controllers\API
 */

class StateAPIController extends InfyOmBaseController
{
    /** @var  StateRepository */
    private $stateRepository;

    public function __construct(StateRepository $stateRepo)
    {
        $this->stateRepository = $stateRepo;
    }

    /**
     * Display a listing of the State.
     * GET|HEAD /states
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if (request()->has('sort')) {
            list($sortCol, $sortDir) = explode('|', request()->sort);
            $query = State::orderBy($sortCol, $sortDir);
        } else {
            $query = State::orderBy('created_at', 'asc');
        }

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where("name", "like", $value)
                  ->orWhere("country_id", "like", $value)
                  ->orWhere("abbr", "like", $value);
            });
        }

        $perPage = request()->has('per_page') ? (int) request()->per_page : null;
        return response()->json($query->paginate($perPage));    
    }

    /**
     * Store a newly created State in storage.
     * POST /states
     *
     * @param CreateStateAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateStateAPIRequest $request)
    {
        $input = $request->all();

        $states = $this->stateRepository->create($input);

        return $this->sendResponse($states->toArray(), 'State saved successfully');
    }

    /**
     * Display the specified State.
     * GET|HEAD /states/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var State $state */
        $state = $this->stateRepository->find($id);

        if (empty($state)) {
            return Response::json(ResponseUtil::makeError('State not found'), 400);
        }

        return $this->sendResponse($state->toArray(), 'State retrieved successfully');
    }

    /**
     * Update the specified State in storage.
     * PUT/PATCH /states/{id}
     *
     * @param  int $id
     * @param UpdateStateAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStateAPIRequest $request)
    {
        $input = $request->all();

        /** @var State $state */
        $state = $this->stateRepository->find($id);

        if (empty($state)) {
            return Response::json(ResponseUtil::makeError('State not found'), 400);
        }

        $state = $this->stateRepository->update($input, $id);

        return $this->sendResponse($state->toArray(), 'State updated successfully');
    }

    /**
     * Remove the specified State from storage.
     * DELETE /states/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var State $state */
        $state = $this->stateRepository->find($id);

        if (empty($state)) {
            return Response::json(ResponseUtil::makeError('State not found'), 400);
        }

        $state->delete();

        return $this->sendResponse($id, 'State deleted successfully');
    }
}
