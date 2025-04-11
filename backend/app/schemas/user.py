from pydantic import BaseModel, EmailStr

class UserBase(BaseModel):
    username: str
    password: str
    first_name: str
    last_name: str
    email: EmailStr
    phone: str

