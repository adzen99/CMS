import models

from fastapi import FastAPI, HTTPException, Depends
from fastapi.middleware.cors import CORSMiddleware
from database import engine, SessionLocal
from sqlalchemy.orm import Session
from base_models import *
from utils import get_bank_from_iban

app = FastAPI()

origins = [
    "http://localhost:5173",
]
app.add_middleware(
    CORSMiddleware,
    allow_origins=origins,
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"], 
)


models.Base.metadata.create_all(bind=engine)


def get_db():
    db = SessionLocal()
    try:
        yield db
    finally:
        db.close()


db_dependency = Depends(get_db)


@app.post("/add_user/")
async def add_user(user: UserBase, db: Session = db_dependency):
    db_user = models.User(
                            username='alex.dzen',
                            password='1234',
                            first_name='alex',
                            last_name='dzen',
                            email='dzenalex9@gmail.com',
                            phone='0751321045')
    db.add(db_user)
    db.commit()
    db.refresh(db_user)


@app.post("/add_company/")
async def add_company(company: CompanyBase, db: Session = db_dependency):
    db_company = models.Company(
                            name=company.name,
                            address=company.address,
                            county=company.county,
                            locality=company.locality,
                            cui=company.cui,
                            nr_reg=company.nr_reg,
                            iban=company.iban,
                            id_user=company.id_user)
    db.add(db_company)
    db.commit()
    db.refresh(db_company)


@app.get("/get_my_companies/{id_user}")
async def get_my_companies(id_user: int, db: Session = db_dependency):
    result = db.query(models.Company).filter(models.Company.id_user == id_user).all()
    for res in result:
        res.bank = get_bank_from_iban(res.iban)
    if not result:
        raise HTTPException(status_code=404, detail="Companies not found!")
    return result


