<H1>Hello</H1>

<table class="table table-primary table-striped table-hover">
    <tr>
        <th>#</th>
        <th>hashName</th>
        <th>name</th>
        <th>lastExecution</th>
        <th>benchMark</th>
        <th>lastStatus</th>
        <th>Action</th>
    </tr>
    {foreach from=$jobs item="job"}
        <tr>
            <td>{$job['id']}</td>
            <td>{$job['hashName']}</td>
            <td>{$job['jobName']}</td>
            <td>{$job['lastEndExecution']}</td>
            <td>{$job['benchmark']}</td>
            <td>{$job['lastStatus']}</td>
            <td><a href="{base_url()}JobEdit/{$job['id']}">Edit</a> delete</td>
        </tr>
    {/foreach}

</table>