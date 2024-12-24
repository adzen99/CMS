from pydantic import BaseModel


class UserBase(BaseModel):
    username: str
    password: str
    first_name: str
    last_name: str
    email: str
    phone: str


class CompanyBase(BaseModel):
    name: str
    address: str
    county: str
    locality: str
    cui: str
    nr_reg: str
    iban: str
    id_user: int