from pydantic import BaseModel

class CompanyBase(BaseModel):
    name: str
    address: str
    county: str
    locality: str
    cui: str
    nr_reg: str
    iban: str
    id_user: int