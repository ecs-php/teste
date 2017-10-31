<?php

namespace Domain\Draw;

use Domain\Draw;
use Infrastructure\BaseRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DrawnRepository
 *
 * @package Domain\Draw
 */
class DrawnRepository extends BaseRepository
{
    /**
     * @var Draw
     */
    protected $model;

    /**
     * DrawnRepository constructor.
     *
     * @param Draw $model
     */
    public function __construct(Draw $model)
    {
        $this->model = $model;
    }

    /**
     * @param Request $request
     *
     * @return array|bool
     */
    public function hasErrors(Request $request)
    {
        $errors = [];
        if (!$request->request->has('date')) {
            $errors[] = 'date is mandatory';
        }
        if ($request->request->has('date') && $request->request->get('date')) {
            if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",
                $request->request->get('birthday'))) {
                $errors[] = 'date incorrect date format, must be YYYY-MM-DD';
            }
        }
        if ($request->request->has('date') && $request->request->get('date') == null) {
            $errors[] = 'date cannot be null';
        }

        return false;
    }

    /**
     * @param Request $request
     *
     * @return Draw
     */
    public function create(Request $request)
    {
        $winner = new Draw();
        $winner->date = $request->request->get('date', null);
        $winner->winner_id = $request->request->get('winner_id', null);
        $winner->save();

        return $winner;
    }

    /**
     * @param Request $request
     * @param Draw $draw
     *
     * @return mixed
     */
    public function update(Request $request, $draw)
    {
        if ($request->request->has('winner_id')) {
            $draw->winner_id = $request->request->get('winner_id');
        }
        $draw->save();

        return $draw;
    }
}