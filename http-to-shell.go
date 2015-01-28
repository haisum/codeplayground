//http-to-shell is a program that listens as http server on  http://localhost:4000,
//execute commands on terminal and returns output to client as a json response
//Author: Haisum Bhatti
package main

import (
	"encoding/json"
	"fmt"
	"log"
	"net/http"
	"os/exec"
)

//Handler for http requests
type Handler struct{}

//this struct holds values to be returned as response to requesting client
type ShellResponse struct {
	Stdout string
	Stderr string
}

//This is main function which listens on port 4000 and replies the result from terminal in json format
func (h Handler) ServeHTTP(
	w http.ResponseWriter,
	r *http.Request) {
	command := r.PostFormValue("command")
	var rs ShellResponse
	rs.execCommand(command)
	//prepare and send json response
	js, err := json.Marshal(rs)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	w.Header().Set("Content-Type", "application/json")
	w.Write(js)
}

//execCommand function takes a command and executes it.
//Maximum time for command to finish is 2 seconds.
//In case of error, error is saved in ShellResponse.stderr variable
//Succesful output is saved in ShellResponse.Stdout
func (rs *ShellResponse) execCommand(command string) {
	if command == "" {
		return
	}
	//timeout is coreutil and terminates program which surpasses supplied duration in seconds
	fmt.Printf("Executing command %s", "timeout 2 "+command)
	out, err := exec.Command("bash", "-c", "timeout 2 "+command).CombinedOutput()
	if err != nil {
		rs.Stderr = err.Error()
		fmt.Printf("\nError occured: %s\n", rs.Stderr)
		if rs.Stderr == "exit status 124" {
			rs.Stdout = "Process took  too long to execute."
		}
	}
	if len(out) > 0 {
		rs.Stdout = string(out[:])
	}
	fmt.Printf("\nOutput: %s\n", rs.Stdout)
}

func main() {
	var h Handler
	fmt.Println("Trying to listen on port 4000")
	err := http.ListenAndServe("localhost:4000", h)
	if err != nil {
		log.Fatal(err)
	}
}
