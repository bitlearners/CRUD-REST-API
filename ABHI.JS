import { useState } from "react";
import { useEffect } from "react";
import JoditEditor from "jodit-react";
import React from "react";
import { useRef } from "react";
import { HiPlusCircle, HiExclamationCircle } from "react-icons/hi";
import axios from "axios";
import Swal from "sweetalert2";

function AddBlog() {
  const editor = useRef(null);

  const [category, setcategory] = useState([]); // for category

  /// const [category, setcategory] = useState([]);
  useEffect(() => {
    getcategory();
  }, []);

  function getcategory() {
    axios
      .get("http://localhost:80/CRUD-REST-API/api_fetch_category.php/")
      .then(function (response) {
        console.log(response.data);
        setcategory(response.data);
      });
  }

  // const [formData, setFormData] = useState({
  //   BName: '',
  //   content: '',
  //   image: null,
  //   BAlt: '',
  //   CID: '',
  // });

  // const fieldChnaged = (event) => {
  //   setFormData({
  //     ...formData,
  //     [event.target.name]: event.target.value,
  //   });
  // };

  // const handleImageChange = (event) => {
  //   setFormData({
  //     ...formData,
  //     image: event.target.files[0],
  //   });
  // };

  // const fieldChnagedvalue = (data) => {
  //   setFormData({ ...formData, content: data }); // this code for to store all data from Rich text editor
  // };

  // const handleFormSubmit = (event) => {

  //   if (formData.BName.trim() === "") {
  //     Swal.fire({
  //       icon: "error",
  //       title: "Oops...",
  //       text: "Please Write Title!",
  //     });
  //     return;
  //   }

  //   if (formData.content.trim() === "") {
  //     Swal.fire({
  //       icon: "error",
  //       title: "Oops...",
  //       text: "Please Write Content",
  //     });
  //     return;
  //   }

  //   if (formData.BAlt.trim() === "") {
  //     Swal.fire({
  //       icon: "error",
  //       title: "Oops...",
  //       text: "Please Write ImgAllt for Image!",
  //     });
  //     return;
  //   }
  //   //submit the form

  //   event.preventDefault();

  //   const formDataToSend = new FormData();
  //   formDataToSend.append('BName', formData.BName);
  //   formDataToSend.append('content', formData.content);
  //   formDataToSend.append('image', formData.image);
  //   formDataToSend.append('BAlt', formData.BAlt);
  //   formDataToSend.append('CID', formData.CID);

  //   axios
  //     .post('http://localhost:80/CRUD-REST-API/api-insert.php', formDataToSend)
  //     .then((response) => {
  //       console.log(response.data);
  //     })
  //     .catch((error) => {
  //       console.error(error);
  //     });

  //     function refreshPage() {
  //       // window.location.reload(false);
  //       console.log(formData);
  //     }

  // };

  // // const [myFile, setMyFile] = useState (null);
  // // const [msg, setMsg] = useState('');
  // // // function selectFile(){
  // // // document .getElementById ('mfile').click();
  // // // }

  // // const fieldChnagedimg = (event) => {
  // //   // this is code catch all the values and pass in to variable
  // //   const apimg = (event .target. files [0]);

  // // };

  const [BName, setBName] = useState("");
  const [content, setContent] = useState("");
  const [image, setImage] = useState(null);
  const [BAlt, setBAlt] = useState("");
  const [CID, setCID] = useState("");

  const handleFormSubmit = async (e) => {
    e.preventDefault();

    try {
      const formData = new FormData();
      formData.append("BName", BName);
      formData.append("content", content);
      formData.append("image", image);
      formData.append("BAlt", BAlt);
      formData.append("CID", CID);

      const response = await axios.post(
        "http://localhost:80/CRUD-REST-API/upload_file.php",
        formData
      );
      console.log(response.data);

      setBName("");
      setContent("");
      setImage(null);
      setBAlt("");
      setCID("");
    } catch (error) {
      console.error(error);
    }
  };

  return (
    <div>
      <section className="text-gray-600 body-font relative">
        <div className="container px-10 py-10 mx-auto">
          <div className="flex flex-col text-center w-full mb-12">
            <h1 className="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">
              Add Blog
            </h1>
          </div>
          <div className="lg:w-1/2 md:w-2/3 mx-auto">
            <form onSubmit={handleFormSubmit}>
              <div className="flex flex-wrap -m-2">
                <div className="p-2 w-full">
                  <div className="relative">
                    <label className="label">
                      <span className="label-text">
                        What is your Blog Title?
                      </span>
                    </label>
                    <input
                      type="text"
                      id="Bnane"
                      placeholder="Type here"
                      className="input input-bordered w-full max-w-xl"
                      name="BName"
                      value={BName}
                      onChange={(e) => setBName(e.target.value)}
                    />
                  </div>
                </div>

                <div className="p-2 w-full">
                  <div className="relative">
                    <label className="label">
                      <span className="label-text">Select Banner Image</span>
                    </label>
                    <input
                      type="file"
                      className="file-input file-input-bordered file-input-primary w-full max-w-xl"
                      id="image"
                      accept=".png, .jpg, .jpeg, .webp"
                      onChange={(e) => {
                        const selectedFile = e.target.files[0];
                        // Perform additional checks if needed
                        if (
                          selectedFile &&
                          [
                            "image/png",
                            "image/jpeg",
                            "image/jpg",
                            "image/webp",
                          ].includes(selectedFile.type)
                        ) {
                          setImage(selectedFile);
                        } else {
                          // Handle file selection error, e.g., show error message
                          console.error(
                            "Please select a PNG, JPG, JPEG, or WebP image file"
                          );
                        }
                      }}
                    />
                  </div>
                </div>

                <div className="p-2 w-1/2">
                  <div className="relative">
                    <label className="label">
                      <span className="label-text">Select Category</span>
                    </label>
                    <select
                      className="select select-bordered w-full max-w-xs"
                      id="CID"
                      name="CID"
                      value={CID}
                      onChange={(e) => setCID(e.target.value)}
                      defaultValue={0}
                    >
                      <option disabled value={0}>
                        Select
                      </option>

                      {category.map((category) => (
                        <option value={category.CID} key={category.CID}>
                          {category.CName}{" "}
                        </option>
                      ))}
                    </select>
                  </div>
                </div>
                <div className="p-2 w-1/2">
                  <div className="relative">
                    <label className="label">
                      <span className="label-text">Alt Tag </span>
                    </label>
                    <input
                      type="text"
                      placeholder="Type here"
                      className="input input-bordered w-full max-w-xl"
                      id="BAlt"
                      name="BAlt"
                      value={BAlt}
                      onChange={(e) => setBAlt(e.target.value)}
                    />
                  </div>
                </div>

                <div className="p-2 w-full">
                  <div className="relative">
                    <label
                      htmlFor="message"
                      className="leading-7 text-sm text-gray-600"
                    >
                      Message
                    </label>

                    <JoditEditor
                      ref={editor}
                      value={content}
                      tabIndex={1} // tabIndex of textarea
                      onBlur={(newContent) => setContent(newContent)} // preferred to use only this option to update the content htmlFor perhtmlFormance reasons
                      // onChange={fieldChnagedvalue}
                      // value={content}
                      onChange={(e) => setContent(e.target.value)}

                 />
                  </div>
                </div>
                <div className="p-2 w-full ">
                  <div className="flex ">
                    <button
                      type="submit"
                      className="btn btn-outline btn-primary m-2"
                    >
                      <HiPlusCircle className="h-6 w-6 " />
                      Publish
                    </button>

                    <button
                      className="btn btn-outline btn-secondary m-2 "
                      type="reset"
                    >
                      <HiExclamationCircle className="h-6 w-6 " />
                      Cancel
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </section>

      {/* <div className='w-[900px] mx-auto  h-auto '>
      <JoditEditor
          ref={editor}
          value={content}
          config={config}
          tabIndex={1} // tabIndex of textarea
          onBlur={newContent => setContent(newContent)} // preferred to use only this option to update the content htmlFor perhtmlFormance reasons
          onChange={newContent => {}}
      />
      </div>
      {content} */}
    </div>
  );
}

export default AddBlog;
