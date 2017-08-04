<?php

/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/05/17
 * Time: 08:48
 */
namespace Core\AutoCron\Traits;

use Core\AutoCron\DbTools;

trait ExecutionLog
{
    protected function logStepStart($stepUid)
    {
        $start = new \DateTime();
        $db = DbTools::getPdo();
        $query = 'INSERT INTO '.DbTools::TABLE_INFO_JOB_STEP_EXECUTIONS.'
                SET uidStep = :uidStep,
                    idJobExecution = :idJobExecution,
                    startDate = :startDate
        ';
        $pdo = DbTools::getPdo();
        $request = $pdo->prepare($query);
        $request->execute(['uidStep'=>$stepUid, 'idJobExecution' => $this->_executionId, 'startDate' => $start->format('Y-m-d H:i:s')]);
        $this->_stepExecutions[$stepUid] = $pdo->lastInsertId();
    }

    protected function logStepEnd($stepUid, $returnCode, $message = null)
    {
        $end = new \DateTime();
        $pdo = DbTools::getPdo();
        $query = 'UPDATE '.DbTools::TABLE_INFO_JOB_STEP_EXECUTIONS.' SET endDate = :endDate, status = :status, message = :message WHERE id = :id';
        $request = $pdo->prepare($query);
        $request->execute(['id' => $this->_stepExecutions[$stepUid], 'endDate' => $end->format('Y-m-d H:i:s'), 'status' => $returnCode, 'message' => $message]);
    }

    protected function logExecutionStart()
    {
        $start = new \DateTime();
        $db = DbTools::getPdo();
        $query = 'INSERT INTO '.DbTools::TABLE_INFO_JOB_EXECUTIONS.'
                SET uidJob = :uidJob,
                    startDate = :startDate
        ';
        $pdo = DbTools::getPdo();
        $request = $pdo->prepare($query);
        $result = $request->execute(['uidJob'=>$this->_job->getInfo('uid'), 'startDate' => $start->format('Y-m-d H:i:s')]);
        $this->_executionId = $pdo->lastInsertId();
    }

    protected function logExecutionEnd($returnCode)
    {
        $end = new \DateTime();
        $pdo = DbTools::getPdo();
        $query = 'UPDATE '.DbTools::TABLE_INFO_JOB_EXECUTIONS.' SET endDate = :endDate, status = :status WHERE id = :id';
        $request = $pdo->prepare($query);
        $request->execute(['id' => $this->_executionId, 'endDate' => $end->format('Y-m-d H:i:s'), 'status' => $returnCode]);
    }
}