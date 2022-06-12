import React, { useState } from 'react'
import Box from '@mui/material/Box';
import TextField from '@mui/material/TextField';


import IconButton from "@mui/material/IconButton";
import OutlinedInput from "@mui/material/OutlinedInput";
import InputLabel from "@mui/material/InputLabel";
import InputAdornment from "@mui/material/InputAdornment";
import FormControl from "@mui/material/FormControl";
import Visibility from "@mui/icons-material/Visibility";
import VisibilityOff from "@mui/icons-material/VisibilityOff";
import Button from '@mui/material/Button';
import { useNavigate } from 'react-router-dom'







const Login = () => {
    let navigate = useNavigate();


const [userData, setUserData] = useState([])
    const [values, setValues] = React.useState({
        amount: "",
        password: "",
        email: "",
        weight: "",
        weightRange: "",
        showPassword: false
    });

    const {email, password} = values;
    console.log(email, password)


    const handleChange = (prop) => (event) => {
        setValues({ ...values, [prop]: event.target.value });
    };

    const handleClickShowPassword = () => {
        setValues({
            ...values,
            showPassword: !values.showPassword
        });
    };

    const handleMouseDownPassword = (event) => {
        event.preventDefault();
    };


    // Login handle
    const loginHandle = async (req, res ) => {
        console.log('object')
        try{
            const user = await fetch('https://phplaravel-786870-2685559.cloudwaysapps.com/api/login', {
                method:'POST',
                headers:{
                    'Content-Type':'application/json'
                },
                body:JSON.stringify( {email, password})
            })
            const data = await user.json();
            setUserData( await data)
        }catch(err){
            console.log(err)
        }

    }


console.log(userData)


    return (
        <div className='container my-5 d-flex justify-content-center' >
            <Box
                sx={{
                    width: 500,
                    maxWidth: '100%',
                }}
                // className='d-flex justify-content-cen flex-column'
                style={{ display: 'flex', alignItems: 'center', justifyContent: 'center', flexDirection: "column" }}
            >
                <TextField style={{ width: '20rem' }} label="Email" className='mb-3' onChange={handleChange("email")} />

                <FormControl sx={{ m: 0, width: "58ch" }} variant="outlined" style={{ width: '20rem' }} className='d-flex justify-content-around'>
                    <InputLabel htmlFor="outlined-adornment-password" >
                        Password
                    </InputLabel>
                    <OutlinedInput
                        id="outlined-adornment-password"
                        type={values.showPassword ? "text" : "password"}
                        value={values.password}
                        onChange={handleChange("password")}
                        endAdornment={
                            <InputAdornment position="end">
                                <IconButton
                                    aria-label="toggle password visibility"
                                    onClick={handleClickShowPassword}
                                    onMouseDown={handleMouseDownPassword}
                                    edge="end"
                                >
                                    {values.showPassword ? <VisibilityOff /> : <Visibility />}
                                </IconButton>
                            </InputAdornment>
                        }
                        label="Password"
                    />
                </FormControl>


                <div className="button  d-flex justify-content-center" style={{ width: '100%' }}>
                    <Button variant="contained" color="primary" className='mt-3' type='submit' onClick={loginHandle}> Submit </Button>
                </div>
            </Box>
        </div>
    )
}

export default Login