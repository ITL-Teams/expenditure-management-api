<?php
namespace App\Application\BudgetCollaboratorRemover;

use App\Domain\IBudgetRepository;
use App\Domain\ValueObject\BudgetId;
use App\Domain\Entity\BudgetQuantities;
use App\Domain\ValueObject\CollaboratorId;
use App\Domain\ValueObject\BudgetLimit;
use App\Domain\ValueObject\BudgetPercentage;
use App\Domain\ValueObject\BudgetQuantity;

class BudgetCollaboratorRemover {
  private IBudgetRepository $repository;

  public function __construct(IBudgetRepository $repository) {
    $this->repository = $repository;
  }

  public function invoke(BudgetCollaboratorRemoverRequest $request): void {
    
    $budgetId = new BudgetId($request->budgetId);

    $budgetExist = $this->repository->budgetFinderId($budgetId);
    
    if($budgetExist==false)
      throw new \Exception('The budget does not exist '.$request->budgetId);

    $collaboratorId = new CollaboratorId($request->collaboratorId);

    $budgetExist = $this->repository->searchBudgetCollaborator($budgetId,$collaboratorId);    
    
    if(!$budgetExist)
      throw new \Exception('this budget is not assigned to this collaborator '.$request->budget_id);
    
    $budgetQuantitiesCollaborator = $this->repository->searchQuantitiesCollaborator($budgetId,$collaboratorId);
    
    $budgetQuantitiesBudget = $this->repository->getBudgetQuantities($budgetId);
    
    $budgetTotalPercentage = $budgetQuantitiesBudget->getPercentage()->toInt() + $budgetQuantitiesCollaborator->getPercentage()->toInt(); 
    
    $budgetUpdated = $this->repository->updatedBudgetQuantities($budgetId,$budgetTotalPercentage);   
    if(!$budgetUpdated)
      throw new \Exception('an error occurred while allocating the budget');    
    
    $budget = $this->repository->budgetCollaboratorRemover($budgetId,$collaboratorId);
  }

}
