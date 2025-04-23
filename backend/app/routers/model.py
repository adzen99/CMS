from fastapi import APIRouter, Depends, HTTPException, Request
from app.database import get_db
from sqlalchemy.orm import Session
from sqlalchemy import desc, and_
from fastapi import Request, Query
from datetime import datetime
from ..model import Model

router = APIRouter(tags=["advertisements"])


@router.post("/add")
def add(data: dict, db: Session = Depends(get_db)):
    print(data)
    model = Model(data['model'], data)
    
    db.add(model.result)
    db.commit()
    db.refresh(model.result)

    return {"message": "Success!"}


@router.get("/get")
def get(request: Request, db: Session = Depends(get_db)):
    data = dict(request.query_params)
    print(data)
    response = []
    return response
