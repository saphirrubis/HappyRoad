import React, { useState, useEffect } from "react";
import { Field, Form, Formik } from "formik";

import { Link } from "react-router-dom";
import {
    URL_ACCOUTMANAGEMENT,
} from "../../constants/urls/urlFrontEnd";

const ModifPassword = () => {

    return (
        <div className="mt-32 mx-auto">
            {/* Bouton RETOUR */}
            <Link to={URL_ACCOUTMANAGEMENT}>
                <div className="bottom-5 right-5 fixed bg-btn-mou opacity-90 p-3 rounded-3xl text-b-g font-text z-10 hover:text-btn-mou hover:bg-b-g">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </div>
            </Link>
            <div className="w-full">

                <div>
                    <h2 className="mt-6 text-3xl font-extrabold text-b-g dark:text-fond">Nouveau mot de passe</h2>
                </div>
                <Formik
                    initialValues={{
                        oldpassword: "",
                        newpassword: "",
                        validnewpassword: "",

                    }}
                >
                    <Form className="mt-8 space-y-6 ">
                        <div className=" opacity-90 max-w-md space-y-8 rounded-3xl border text-b-g dark:text-fond border-navfoo dark:border-fond p-4 py-12 px-4 shadow-xl shadow-white500/100">
                            <div className="flex flex-col space-y-3 rounded-md shadow-sm">
                                <label htmlFor="oldpassword">Ancien mot de passe</label>
                                <Field
                                    type="password"
                                    name="oldpassword"
                                    placeholder="Votre ancien mot de passe"
                                    className="input font-text"
                                />
                                <label htmlFor="newpassword">Nouveau mot de passe</label>
                                <Field
                                    type="password"
                                    name="newpassword"
                                    placeholder="Votre nouveau mot de passe"
                                    className="input font-text"
                                />
                                <label htmlFor="validnewpassword">Confirmation mot de passe</label>
                                <Field
                                    type="password"
                                    name="validnewpassword"
                                    placeholder="Confirmation de votre nouveau mot de passe"
                                    className="input font-text"
                                />
                            </div>

                        </div>
                        <div>
                            <button
                                type="submit"
                                className="text-xl font-medium bg-btn-mou text-b-g hover:bg-b-g group hover:text-btn-mou p-3 rounded-xl group relative w-1/2 font-button ml-40"
                            >
                                Valider
                            </button>
                        </div>
                    </Form>
                </Formik>
            </div>

        </div>
    )
};

export default ModifPassword;