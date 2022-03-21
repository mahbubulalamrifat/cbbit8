<template>
    <div>
        <v-card>
            <v-card-text>
                <div class="d-flex justify-content-between">
                    <h4>Applications</h4>
                    <v-btn outlined :to="{ name: 'Dashboard'}" class="text-decoration-none"><v-icon left>mdi-plus</v-icon> New</v-btn>
                </div>
                <div class="mt-4 mb-3">
                    <div class="font-weight-bold">Archived Application(s)</div>
                    <div class="table-responsive mt-1">
                        <table class="table">
                            <tr>
                                <th style="border-top:none">Reference No</th>
                                <th style="border-top:none">Application Type</th>
                                <th style="border-top:none">Apply Date</th>
                                <th style="border-top:none">Status</th>
                            </tr>
                            <tr>
                                <td>48735</td>
                                <td>Official Email Request</td>
                                <td>11/6/2018 9:21:45 PM</td>
                                <td>Calcelled</td>
                            </tr>
                            <tr>
                                <td>48135</td>
                                <td>Account/Authority Request</td>
                                <td>11/6/2018 9:21:45 PM</td>
                                <td>Accepted</td>
                            </tr>
                            <tr>
                                <td>42335</td>
                                <td>Guest User Request</td>
                                <td>11/6/2018 9:21:45 PM</td>
                                <td>Rejected</td>
                            </tr>
                        </table>
                    </div>
                </div>


                <div class="mt-5 mb-2">
                    <div class="font-weight-bold">Current Application(s)</div>
                    <div class="table-responsive mt-1">
                        <table class="table">
                            <tr>
                                <th style="border-top:none">Reference No</th>
                                <th style="border-top:none">Application Type</th>
                                <th style="border-top:none">Apply Date</th>
                                <th style="border-top:none">Status</th>
                            </tr>
                            <tr>
                                <td>48735</td>
                                <td>Official Email Request</td>
                                <td>1/6/2018 9:21:45 PM</td>
                                <td>Waiting For Manager Approval</td>
                            </tr>
                            <tr>
                                <td>48135</td>
                                <td>Account/Authority Request</td>
                                <td>11/6/2018 9:21:45 PM</td>
                                <td>Waiting For BU Head Approval</td>
                            </tr>
                            <tr>
                                <td>42335</td>
                                <td>Guest User Request</td>
                                <td>11/6/2018 9:21:45 PM</td>
                                <td>Waiting For CPB-IT Approval</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </v-card-text>
        </v-card>
    </div>
</template>