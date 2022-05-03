package api

import (
	"encoding/json"
	"errors"
	"fmt"
	"io"
	"net/http"
)

func checkApiResponse(response *http.Response) ([]byte, error) {
	// status
	if response.StatusCode == 500 {
		return nil, errors.New("status code: 500")
	}

	// body
	bodyBytes, err := io.ReadAll(response.Body)
	if err != nil {
		return nil, errors.New("read response body error: " + err.Error())
	}
	body := make(map[string]interface{})
	err = json.Unmarshal(bodyBytes, &body)
	if err != nil {
		return nil, errors.New("unmarshal body error: " + err.Error())
	}

	// success
	success, ok := body["success"]
	if !ok {
		return nil, errors.New(fmt.Sprintf("body structure invalid: %s", string(bodyBytes)))
	}
	switch v := success.(type) {
	case bool:
		if success != true {
			return nil, errors.New(fmt.Sprintf("success false\nmessage: %s", body["message"]))
		}
	default:
		return nil, errors.New(fmt.Sprintf("success field invalid type: %T", v))
	}

	result, _ := json.Marshal(body["result"])
	return result, nil
}
